<?php

/**
 * Created by PhpStorm.
 * User: mojtaba
 * Date: 6/18/17
 * Time: 7:02 PM
 */
if ( ! class_exists( 'WC_Payment_Gateway' ) ) {
	return;
}

class WC_SEP_Gateway extends WC_Payment_Gateway {

	protected $authority;

	private $merchant_id;
	private $username;
	private $password;


	public function __construct() {
		$this->id                 = 'sep_gateway';
		$this->icon               = SEPWG_URL . 'assets/images/sep-logo-small.png';
		$this->has_fields         = true;
		$this->method_title       = __( 'SEP gateway for Woocommerce', 'sepwg' );
		$this->method_description = __( 'Official Saman electronic payment gateway for Woocommerce', 'sepwg' );

		// Load the settings.
		$this->init_form_fields();
		$this->init_settings();

		// Define user set variables
		$this->title       = $this->get_option( 'title' );
		$this->description = $this->get_option( 'description' );
		$this->merchant_id = $this->get_option( 'merchant_id' );

		// Actions
		add_action( 'woocommerce_update_options_payment_gateways_' . $this->id,
			array( $this, 'process_admin_options' ) );
		add_action( 'woocommerce_receipt_' . $this->id, array( $this, 'send_to_bank' ) );
		add_action( 'woocommerce_api_' . strtolower( get_class( $this ) ), array( $this, 'return_from_bank' ) );
		add_filter( 'woocommerce_get_order_item_totals', array( $this, 'show_transaction_in_order' ), 10, 2 );

	}

	/**
	 * Initialise Gateway Settings Form Fields.
	 */
	public function init_form_fields() {
		$this->form_fields = array(
			'enabled'     => array(
				'title'   => __( 'Enable/Disable', 'sepwg' ),
				'type'    => 'checkbox',
				'label'   => __( 'Enable sep Payments', 'sepwg' ),
				'default' => 'yes',
			),
			'title'       => array(
				'title'       => __( 'Title', 'sepwg' ),
				'type'        => 'text',
				'description' => __( 'This controls the title which the user sees during checkout.', 'sepwg' ),
				'default'     => __( 'SEP gateway for Woocommerce', 'sepwg' ),
				'desc_tip'    => true,
			),
			'description' => array(
				'title'       => __( 'Description', 'sepwg' ),
				'type'        => 'textarea',
				'description' => __( 'Payment method description that the customer will see on your checkout.',
					'sepwg' ),
				'default'     => __( 'Official Saman electronic payment gateway', 'sepwg' ),
				'desc_tip'    => true,
			),
			'merchant_id' => array(
				'title'       => __( 'Terminal ID', 'sepwg' ),
				'type'        => 'text',
				'description' => __( 'Insert Terminal id that received from sep', 'sepwg' ),
			),
			'username' => array(
				'title' => __('Username', 'sepwg'),
				'type' => 'text',
				'description' => __('Enter gateway username (By default: merchant id)', 'sepwg'),
			),
			'password' => array(
				'title' => __('Password', 'sepwg'),
				'type' => 'text',
				'description' => __('Enter gateway password', 'sepwg'),
			)
		);
	}

	/**
	 * Process the payment and return the result.
	 *
	 * @param int $order_id
	 *
	 * @return array
	 */
	public function process_payment( $order_id ) {
		$order = wc_get_order( $order_id );

		return array(
			'result'   => 'success',
			'redirect' => $order->get_checkout_payment_url( $order ),
		);
	}

	/**
	 * Make ready for send to bank.
	 */
	public function send_to_bank( $order_id ) {
		_e( 'Thank you for your payment. redirecting to bank...', 'sepwg' );
		$this->post_form( $order_id );
	}

	public function post_form( $order_id ) {
		$order    = wc_get_order( $order_id );
		$currency = $order->get_currency();
		$amount   = intval( $order->get_total() );
		if ( strtolower( $currency ) == strtolower( 'IRT' ) || strtolower( $currency ) == strtolower( 'TOMAN' ) || strtolower( $currency ) == strtolower( 'Iran TOMAN' ) || strtolower( $currency ) == strtolower( 'Iranian TOMAN' ) || strtolower( $currency ) == strtolower( 'Iran-TOMAN' ) || strtolower( $currency ) == strtolower( 'Iranian-TOMAN' ) || strtolower( $currency ) == strtolower( 'Iran_TOMAN' ) || strtolower( $currency ) == strtolower( 'Iranian_TOMAN' ) || strtolower( $currency ) == strtolower( 'تومان' ) || strtolower( $currency ) == strtolower( 'تومان ایران' ) ) {
			$amount = $amount * 10;
		} elseif ( strtolower( $currency ) == strtolower( 'IRHT' ) ) {
			$amount = $amount * 1000 * 10;
		} elseif ( strtolower( $currency ) == strtolower( 'IRHR' ) ) {
			$amount = $amount * 1000;
		}
		$merchant_id = $this->merchant_id;
		$res_num     = time();
		WC()->session->set( 'sep_order_id', $order_id );
		$callback_url = add_query_arg( 'wc_order', $order_id, WC()->api_request_url( 'WC_sep_Gateway' ) );

		$curl = curl_init();

		$params = [
			"Action"          => "Token",
			"Amount"          => intval( $amount ),
			"Wage"            => 0,
			"AffectiveAmount" => "",
			"TerminalId"      => $merchant_id,
			"ResNum"          => $res_num,
			"RedirectURL"     => $callback_url,
			"CellNumber"      => $order->get_billing_phone(),
		];

		curl_setopt_array( $curl, [
			CURLOPT_URL            => "https://sep.shaparak.ir/MobilePG/MobilePayment",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING       => "",
			CURLOPT_MAXREDIRS      => 10,
			CURLOPT_TIMEOUT        => 60,
			CURLOPT_CUSTOMREQUEST  => "POST",
			CURLOPT_POSTFIELDS     => json_encode( $params ),
			CURLOPT_HTTPHEADER     => [
				"Content-Type: application/json"
			],
		] );

		$response = curl_exec( $curl );
		$err      = curl_error( $curl );

		curl_close( $curl );

		if ( $err ) {
			wc_add_notice( __( 'Payment error:', 'sepwg' ) . $err, 'error' );
			echo '<a href="' . wc_get_checkout_url() . '">' . __( 'Go back to checkout', 'sepwg' ) . '</a>';
		} else {
			$response = json_decode( $response );
			if ( $response->status == 1 ) {
				$post_url = 'https://sep.shaparak.ir/OnlinePG/OnlinePG';
				$form     = '<form id="sep_hidden_form" method="post" action="' . $post_url . '">
                        <input type="hidden" name="Token" value="' . $response->token . '">
                         <input name="GetMethod" type="text" value="false"> <!--true | false | empty string | null-->
                        <script type="text/javascript">
                            document.getElementById("sep_hidden_form").submit();
                        </script>
                    </form>';
				echo $form;
			} else {
				wc_add_notice( $response->errorDesc, 'error' );
				echo '<a href="' . wc_get_checkout_url() . '">' . __( 'Go back to checkout', 'sepwg' ) . '</a>';
			}

		}


	}

	public function return_from_bank() {
		if ( isset( $_GET['wc_order'] ) ) {
			$order_id = absint( $_GET['wc_order'] );
		} else {
			$order_id = absint( WC()->session->get( 'sep_order_id' ) );
		}
		if ( isset( $order_id ) && ! empty( $order_id ) ) {
			$order = wc_get_order( $order_id );
			if ( $order->get_status() !== 'completed' ) {
				$currency = $order->get_currency();

				// Get data from bank
				$merchant_id  = $_POST['MID'];
				$state        = $_POST['State'];
				$state_code   = $_POST['Status'];
				$rrn_num      = $_POST['RRN'];
				$ref_num      = $_POST['RefNum'];
				$res_num      = $_POST['ResNum'];
				$TerminalId   = $_POST['TerminalId'];
				$trace_number = $_POST['TRACENO'];
				$payment_card = $_POST['SecurePan'];
				$paid_amount  = $_POST['Amount'];


				if ( $state_code == 2 ) {
					// Check RefNum
					$args        = array(
						'posts_per_page' => - 1,
						'post_type'      => 'shop_order',
						'meta_key'       => '_sep_ref_num',
						'meta_value'     => $ref_num
					);
					$check_query = new WP_Query( $args );
					$founded_ref = $check_query->found_posts;
					wp_reset_postdata();
					if ( $founded_ref ) {
						$error_message = $this->get_error_message( 'duplicated_ref' );
						wc_add_notice( __( 'Payment error:', 'sepwg' ) . $error_message, 'error' );
					} else {
						update_post_meta( $order_id, '_sep_ref_num', $ref_num );
						try {
							$soap_client = new soapclient( 'https://sep.shaparak.ir/Payments/referencepayment.asmx?wsdl' );
							$verify      = $soap_client->VerifyTransaction( $ref_num,  $this->merchant_id );
							$amount      = intval( $order->get_total() );
							if ( strtolower( $currency ) == strtolower( 'IRT' ) || strtolower( $currency ) == strtolower( 'TOMAN' ) || strtolower( $currency ) == strtolower( 'Iran TOMAN' ) || strtolower( $currency ) == strtolower( 'Iranian TOMAN' ) || strtolower( $currency ) == strtolower( 'Iran-TOMAN' ) || strtolower( $currency ) == strtolower( 'Iranian-TOMAN' ) || strtolower( $currency ) == strtolower( 'Iran_TOMAN' ) || strtolower( $currency ) == strtolower( 'Iranian_TOMAN' ) || strtolower( $currency ) == strtolower( 'تومان' ) || strtolower( $currency ) == strtolower( 'تومان ایران' ) ) {
								$amount = $amount * 10;
							} elseif ( strtolower( $currency ) == strtolower( 'IRHT' ) ) {
								$amount = $amount * 1000 * 10;
							} elseif ( strtolower( $currency ) == strtolower( 'IRHR' ) ) {
								$amount = $amount * 1000;
							}

							if ( $verify == $amount ) {
								// Everything is OK!
								wc_reduce_stock_levels( $order_id );
								WC()->cart->empty_cart();
								WC()->session->delete_session( 'sep_order_id' );
								update_post_meta( $order_id, 'sep_trace_number', $trace_number );
								$message = sprintf( __( 'Payment was successful %s Tracking Code: %s', 'sepwg' ),
									'<br />', $trace_number );
								$order->add_order_note( $message );
								$order->payment_complete();
								$successful_page = add_query_arg( 'wc_status', 'success',
									$this->get_return_url( $order ) );
								wp_redirect( $successful_page );
								exit();
							} elseif ( $verify < 0 ) {
								// Cancel payment and reverse money
								$reverse = $soap_client->reverseTransaction( $ref_num, $merchant_id, $this->username,
									$this->password );
								if ( $reverse == 1 ) {
									$order->add_order_note( __( 'Transaction was successful reserved', 'sepwg' ) );
								} elseif ( $reverse == '-1' ) {
									$order->add_order_note( __( 'Transaction was not reserved. something goes wrong!',
										'sepwg' ) );
								}
								$error_message = $this->get_error_message( 'verify' );
								wc_add_notice( __( 'Payment error:', 'sepwg' ) . $error_message, 'error' );
								wp_redirect( wc_get_checkout_url() );
								exit();
							}

						} catch ( Exception $e ) {
							//var_dump($e->getMessage());
							$error_message = $this->get_error_message( '-19' );
							wc_add_notice( __( 'Payment error:', 'sepwg' ) . $error_message, 'error' );
							echo '<a href="' . wc_get_checkout_url() . '">' . __( 'Go back to checkout',
									'sepwg' ) . '</a>';
						}
					}
				} else {
					if ( $state_code == 1 ) {
						$message = __( 'Payment canceled by user', 'sepwg' );
					} elseif ( $state_code == 3 ) {
						$message = __( 'Payment failed', 'sepwg' );
					} elseif ( $state_code == 4 ) {
						$message = __( 'Payment SessionIsNull', 'sepwg' );
					} elseif ( $state_code == 5 ) {
						$message = __( 'Payment InvalidParameters', 'sepwg' );
					} elseif ( $state_code == 8 ) {
						$message = __( 'Payment MerchantIpAddressIsInvalid', 'sepwg' );
					} elseif ( $state_code == 10 ) {
						$message = __( 'Payment TokenNotFound', 'sepwg' );
					} elseif ( $state_code == 11 ) {
						$message = __( 'Payment TokenRequired', 'sepwg' );
					} elseif ( $state_code == 12 ) {
						$message = __( 'Payment TerminalNotFound', 'sepwg' );
					}

					wc_add_notice( $message, 'error' );
					wp_redirect( wc_get_checkout_url() );
					exit();
				}


				if ( strtolower( $state ) == 'ok' ) {
					// BOOM! Payment completed!

					// Check RefNum
					$args        = array(
						'posts_per_page' => - 1,
						'post_type'      => 'shop_order',
						'meta_key'       => '_sep_ref_num',
						'meta_value'     => $ref_num
					);
					$check_query = new WP_Query( $args );
					$founded_ref = $check_query->found_posts;
					wp_reset_postdata();
					if ( $founded_ref ) {
						$error_message = $this->get_error_message( 'duplicated_ref' );
						wc_add_notice( __( 'Payment error:', 'sepwg' ) . $error_message, 'error' );
					} else {
						update_post_meta( $order_id, '_sep_ref_num', $ref_num );
						try {
							$soap_client = new soapclient( 'https://sep.shaparak.ir/Payments/referencepayment.asmx?wsdl' );
							$verify      = $soap_client->VerifyTransaction( $ref_num, $merchant_id );
							$amount      = intval( $order->get_total() );
							if ( strtolower( $currency ) == strtolower( 'IRT' ) || strtolower( $currency ) == strtolower( 'TOMAN' ) || strtolower( $currency ) == strtolower( 'Iran TOMAN' ) || strtolower( $currency ) == strtolower( 'Iranian TOMAN' ) || strtolower( $currency ) == strtolower( 'Iran-TOMAN' ) || strtolower( $currency ) == strtolower( 'Iranian-TOMAN' ) || strtolower( $currency ) == strtolower( 'Iran_TOMAN' ) || strtolower( $currency ) == strtolower( 'Iranian_TOMAN' ) || strtolower( $currency ) == strtolower( 'تومان' ) || strtolower( $currency ) == strtolower( 'تومان ایران' ) ) {
								$amount = $amount * 10;
							} elseif ( strtolower( $currency ) == strtolower( 'IRHT' ) ) {
								$amount = $amount * 1000 * 10;
							} elseif ( strtolower( $currency ) == strtolower( 'IRHR' ) ) {
								$amount = $amount * 1000;
							}

							if ( $verify == $amount ) {
								// Everything is OK!
								wc_reduce_stock_levels( $order_id );
								WC()->cart->empty_cart();
								WC()->session->delete_session( 'sep_order_id' );
								update_post_meta( $order_id, 'sep_trace_number', $trace_number );
								$message = sprintf( __( 'Payment was successful %s Tracking Code: %s', 'sepwg' ),
									'<br />', $trace_number );
								$order->add_order_note( $message );
								$order->payment_complete();
								$successful_page = add_query_arg( 'wc_status', 'success',
									$this->get_return_url( $order ) );
								wp_redirect( $successful_page );
								exit();
							} elseif ( $verify < 0 ) {
								// Cancel payment and reverse money
								$reverse = $soap_client->reverseTransaction( $ref_num, $merchant_id, $this->username,
									$this->password );
								if ( $reverse == '1' ) {
									$order->add_order_note( __( 'Transaction was successful reserved', 'sepwg' ) );
								} elseif ( $reverse == '-1' ) {
									$order->add_order_note( __( 'Transaction was not reserved. something goes wrong!',
										'sepwg' ) );
								}
								$error_message = $this->get_error_message( 'verify' );
								wc_add_notice( __( 'Payment error:', 'sepwg' ) . $error_message, 'error' );
								wp_redirect( wc_get_checkout_url() );
								exit();
							}

						} catch ( Exception $e ) {
							//var_dump($e->getMessage());
							$error_message = $this->get_error_message( '-19' );
							wc_add_notice( __( 'Payment error:', 'sepwg' ) . $error_message, 'error' );
							echo '<a href="' . wc_get_checkout_url() . '">' . __( 'Go back to checkout',
									'sepwg' ) . '</a>';
						}
					}

				} else {
					// OOPS! Something wrong
					$error_message = $this->get_error_message( $state );
					wc_add_notice( __( 'Payment error:', 'sepwg' ) . $error_message, 'error' );
					wp_redirect( wc_get_checkout_url() );
					exit();
				}


			}
		}
	}

	public function get_error_message( $token ) {
		switch ( $token ) {
			case '-1':
				return __( 'Error in processing submitted data', 'sepwg' );
				break;
			case '-3':
				return __( 'Invalid character in inputs', 'sepwg' );
				break;
			case '-4':
				return __( 'Merchant Authentication Failed', 'sepwg' );
				break;
			case '-6':
				return __( 'Order completed before or 30 minute passed', 'sepwg' );
				break;
			case '-7':
				return __( 'Empty digital receipt', 'sepwg' );
				break;
			case '-8':
				return __( 'Length of inputs is bigger than valid number', 'sepwg' );
				break;
			case '-9':
				return __( 'Invalid character in passed amount', 'sepwg' );
				break;
			case '-10':
				return __( 'Invalid character in digital receipt', 'sepwg' );
				break;
			case '-11':
				return __( 'Length of inputs is smaller than valid number', 'sepwg' );
				break;
			case '-12':
				return __( 'Amount is negative', 'sepwg' );
				break;
			case '-13':
				return __( 'Passed price is more than refunded digital recipient', 'sepwg' );
				break;
			case '-14':
				return __( 'Transaction does not exist', 'sepwg' );
				break;
			case '-15':
				return __( 'Passed amount in decimal', 'sepwg' );
				break;
			case '-16':
				return __( 'System error', 'sepwg' );
				break;
			case '-17':
				return __( 'Refunding transaction is not valid', 'sepwg' );
				break;
			case '-18':
				return __( 'IP Address is invalid.', 'sepwg' );
				break;
			case '-19':
				return __( 'Connection to bank failed.', 'sepwg' );
				break;
			case 'duplicated_ref':
				return __( 'Your reference number already exist.', 'sepwg' );
				break;
			case 'verify':
				return __( 'There is something wrong with your payment. if money reduced from your account, it will be returned after 72 hour.',
					'sepwg' );
				break;
			case 'Canceled By User':
				return __( 'Transaction canceled by user.', 'sepwg' );
				break;
			case 'Invalid Amount':
				return __( 'Amount of verifier transaction is greater than main transaction.', 'sepwg' );
				break;
			case 'Invalid Transaction':
				return __( 'Reverse request received but main transaction not found', 'sepwg' );
				break;
			case 'Invalid Card Number':
				return __( 'Card number is invalid', 'sepwg' );
				break;
			case 'No Such Issuer':
				return __( 'No Such Issuer', 'sepwg' );
				break;
			case 'Expired Card Pick Up':
				return __( 'Expired Card Pick Up', 'sepwg' );
				break;
			case 'Allowable PIN Tries Exceeded Pick Up':
				return __( 'Allowable PIN Tries Exceeded Pick Up', 'sepwg' );
				break;
			case 'Incorrect PIN':
				return __( 'Incorrect PIN', 'sepwg' );
				break;
			case 'Exceeds Withdrawal Amount Limit':
				return __( 'Exceeds Withdrawal Amount Limit', 'sepwg' );
				break;
			case 'Transaction Cannot Be Completed':
				return __( 'Transaction Cannot Be Completed', 'sepwg' );
				break;
			case 'Response Received Too Late':
				return __( 'Response Received Too Late', 'sepwg' );
				break;
			case 'Suspected Fraud Pick Up':
				return __( 'Suspected Fraud Pick Up', 'sepwg' );
				break;
			case 'No Sufficient Funds':
				return __( 'No Sufficient Funds', 'sepwg' );
				break;
			case 'Issuer Down Slm':
				return __( 'Issuer Down Slm', 'sepwg' );
				break;
			case 'TME Error':
				return __( 'TME Error', 'sepwg' );
				break;
			default:
				return __( 'Unknown error', 'sepwg' );
		}
	}

	public function show_transaction_in_order( $total_rows, $order ) {
		$gateway = $order->get_payment_method();
		if ( $gateway === $this->id ) {
			$trace_number               = get_post_meta( $order->id, 'sep_trace_number', true );
			$total_rows['trace_number'] = array(
				'label' => __( 'Tracking Code:', 'sepwg' ),
				'value' => $trace_number
			);
		}

		return $total_rows;
	}

}