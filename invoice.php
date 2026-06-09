<?php 
if ( ! defined( 'ABSPATH' ) ) exit; 

// Self-contained Indian Numbering System Converter
if ( ! function_exists( 'satrendz_num_to_words' ) ) {
	function satrendz_num_to_words($no) {
		$words = array(
			0 => '', 1 => 'One', 2 => 'Two', 3 => 'Three', 4 => 'Four', 5 => 'Five',
			6 => 'Six', 7 => 'Seven', 8 => 'Eight', 9 => 'Nine', 10 => 'Ten',
			11 => 'Eleven', 12 => 'Twelve', 13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
			16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen', 19 => 'Nineteen',
			20 => 'Twenty', 30 => 'Thirty', 40 => 'Forty', 50 => 'Fifty',
			60 => 'Sixty', 70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety'
		);
		
		$no = (int) round($no, 0);
		if ($no == 0) return 'Zero Only';
		
		$divider = array(10000000, 100000, 1000, 100, 1);
		$count = count($divider);
		$res = array();
		
		$plural = array('Crore', 'Lakh', 'Thousand', 'Hundred', '');
		
		for ($i = 0; $i < $count; $i++) {
			if ($no >= $divider[$i]) {
				$amt = (int)($no / $divider[$i]);
				$no %= $divider[$i];
				
				if ($amt > 19) {
					$str = $words[(int)($amt / 10) * 10] . ' ' . $words[$amt % 10];
				} else {
					$str = $words[$amt];
				}
				
				if ($str) {
					$res[] = $str . ' ' . $plural[$i];
				}
			}
		}
		
		return implode(' ', array_filter($res)) . ' Only';
	}
}
?>

<div class="invoice-master-box">

	<!-- Top Title Bar Segment -->
	<table class="title-bar-table">
		<tr>
			<td class="left-title">TAX INVOICE: <?php if ( method_exists( $this, 'invoice_number' ) ) { $this->invoice_number(); } ?></td>
			<td class="right-title">ORIGINAL FOR RECIPIENT</td>
		</tr>
	</table>

	<!-- Master Vendor Profile Header Block -->
	<table class="vendor-header-table">
		<tr>
			<td class="logo-cell">
				<?php
				if ( method_exists( $this, 'has_header_logo' ) && $this->has_header_logo() ) {
					$this->header_logo();
				} else {
					echo '<div class="fallback-logo-icon">🛍️</div>';
				}
				?>
			</td>
			<td class="vendor-details-cell">
				<div class="vendor-gstin">GSTIN : 33GAJAL1234A1Z1</div>
				<div class="vendor-name"><?php if ( method_exists( $this, 'shop_name' ) ) { $this->shop_name(); } else { echo "SATRENDZ"; } ?></div>
				<div class="vendor-address">
					<?php if ( method_exists( $this, 'shop_address' ) ) { $this->shop_address(); } else { echo "Online Fashion & Dance Gear Hub, Tamil Nadu, India"; } ?>
				</div>
				<div class="vendor-contact">Contact No. : +91 8754531686 | Email : gajalaksh19@gmail.com</div>
			</td>
		</tr>
	</table>

	<!-- Split Metadata Row: Left (Addresses) vs Right (Logistics Grid) -->
	<table class="split-metadata-table">
		<tr>
			<!-- Left Column: Bill To & Ship To Boxes -->
			<td class="address-side-cell">
				
				<!-- Bill To Sub-Box -->
				<div class="address-block-header">Bill To</div>
				<div class="address-block-body">
					<strong>Name :</strong> <?php if ( $this->order ) { echo esc_html( $this->order->get_billing_first_name() . ' ' . $this->order->get_billing_last_name() ); } ?><br>
					<strong>Address :</strong> <?php if ( method_exists( $this, 'billing_address' ) ) { $this->billing_address(); } ?><br>
					<strong>State :</strong> <?php if ( $this->order ) { echo esc_html( $this->order->get_billing_state() ); } ?><br>
					<?php 
					if ( ! empty( $this->order ) ) {
						$billing_gstin = $this->order->get_meta( '_billing_gstin' );
						if ( ! empty( $billing_gstin ) ) {
							echo '<strong>GSTIN :</strong> ' . esc_html( strtoupper( $billing_gstin ) );
						}
					}
					?>
				</div>

				<!-- Ship To Sub-Box -->
				<div class="address-block-header border-top-divider">Ship To</div>
				<div class="address-block-body">
					<strong>Name :</strong> <?php if ( $this->order ) { echo esc_html( $this->order->get_shipping_first_name() . ' ' . $this->order->get_shipping_last_name() ); } ?><br>
					<strong>Address :</strong> <?php if ( method_exists( $this, 'needs_shipping_address' ) && $this->needs_shipping_address() && method_exists( $this, 'shipping_address' ) ) { $this->shipping_address(); } else { if ( method_exists( $this, 'billing_address' ) ) { $this->billing_address(); } } ?><br>
					<strong>State :</strong> <?php if ( $this->order ) { echo esc_html( $this->order->get_shipping_state() ? $this->order->get_shipping_state() : $this->order->get_billing_state() ); } ?>
				</div>

			</td>

			<!-- Right Column: Structured Line Grid -->
			<td class="grid-side-cell">
				<table class="logistics-inner-grid">
					<tr>
						<th># Inv. No. :</th>
						<td><?php if ( method_exists( $this, 'invoice_number' ) ) { $this->invoice_number(); } ?></td>
					</tr>
					<tr>
						<th>Inv. Date :</th>
						<td><?php if ( method_exists( $this, 'invoice_date' ) ) { $this->invoice_date(); } ?></td>
					</tr>
					<tr>
						<th>Payment Mode :</th>
						<td><?php if ( $this->order ) { echo esc_html( $this->order->get_payment_method_title() ); } ?></td>
					</tr>
					<tr>
						<th>Reverse Charge :</th>
						<td>NO</td>
					</tr>
					<tr class="grid-section-divider">
						<th>Buyer's Order No :</th>
						<td>#<?php if ( method_exists( $this, 'order_number' ) ) { $this->order_number(); } ?></td>
					</tr>
					<tr>
						<th>Supplier's Ref. :</th>
						<td>-</td>
					</tr>
					<tr>
						<th>Vehicle Number :</th>
						<td><?php echo esc_html( $this->order ? $this->order->get_meta('_vehicle_number') : '-' ); ?></td>
					</tr>
					<tr>
						<th>Delivery Date :</th>
						<td>-</td>
					</tr>
					<tr>
						<th>Transport Details :</th>
						<td><?php echo method_exists( $this->order, 'get_shipping_method' ) ? esc_html( $this->order->get_shipping_method() ) : '-'; ?></td>
					</tr>
					<tr>
						<th>Terms Of Delivery :</th>
						<td>Door Delivery</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>

	<!-- Itemized Grid -->
	<table class="order-details-matrix">
		<thead>
			<tr>
				<th rowspan="2" class="col-sr">Sr</th>
				<th rowspan="2" class="col-desc">Goods & Service Description</th>
				<th rowspan="2" class="col-hsn">HSN</th>
				<th rowspan="2" class="col-qty">Quantity</th>
				<th rowspan="2" class="col-rate">Rate</th>
				<th rowspan="2" class="col-taxable">Taxable</th>
				<th colspan="2" class="col-gst-group">GST</th>
				<th rowspan="2" class="col-total">Total</th>
			</tr>
			<tr>
				<th class="col-gst-pc">%</th>
				<th class="col-gst-amt">Amt.</th>
			</tr>
		</thead>
		<tbody>
			<?php 
			$items = method_exists( $this, 'get_order_items' ) ? $this->get_order_items() : [];
			$sr = 1;
			
			$total_qty_counter = 0;
			$total_taxable_counter = 0;
			$total_tax_counter = 0;
			$total_gross_counter = 0;

			foreach ( $items as $item_id => $item ) : 
				$wc_item = isset( $item['item'] ) ? $item['item'] : null;
				$product = isset( $item['product'] ) ? $item['product'] : null;
				
				$item_taxable = 0;
				$item_tax     = 0;
				$qty          = 0;
				
				if ( $wc_item instanceof WC_Order_Item_Product ) {
					$item_taxable = (float) $wc_item->get_total();
					$item_tax     = (float) $wc_item->get_total_tax();
					$qty          = (int) $wc_item->get_quantity();
					
					if ( empty( $item_tax ) ) {
						$taxes = $wc_item->get_taxes();
						$item_tax = (float) array_sum( $taxes['total'] ?? [] );
					}
				}
				
				$gst_rate = 0;
				$hsn_code = '';
				if ( $product instanceof WC_Product ) {
					$gst_rate = (float) $product->get_meta( '_satrendz_gst_percentage', true );
					$hsn_code = $product->get_meta( '_satrendz_hsn_code', true );
				}

				if ( empty( $gst_rate ) && $item_tax > 0 && $item_taxable > 0 ) {
					$gst_rate = round( ( $item_tax / $item_taxable ) * 100 );
				}

				if ( empty( $item_tax ) && ! empty( $this->order ) ) {
					$order_tax_totals = $this->order->get_tax_totals();
					if ( ! empty( $order_tax_totals ) ) {
						$total_order_tax = 0;
						foreach ( $order_tax_totals as $tax_line ) { $total_order_tax += $tax_line->amount; }
						$order_subtotal = (float) $this->order->get_subtotal();
						if ( $total_order_tax > 0 && $order_subtotal > 0 ) {
							$gst_rate = round( ( $total_order_tax / $order_subtotal ) * 100 );
							$item_tax = ( $item_taxable / $order_subtotal ) * $total_order_tax;
						}
					}
				}

				$rate = $qty > 0 ? ( $item_taxable / $qty ) : 0;
				$item_total = $item_taxable + $item_tax;

				$total_qty_counter += $qty;
				$total_taxable_counter += $item_taxable;
				$total_tax_counter += $item_tax;
				$total_gross_counter += $item_total;
			?>
				<tr>
					<td class="col-sr text-center"><?php echo esc_html( $sr++ ); ?></td>
					<td class="col-desc">
						<span class="item-main-name"><?php echo esc_html( $item['name'] ?? '' ); ?></span>
						<?php if ( ! empty( $item['sku'] ) ) : ?>
							<span class="item-sku-tag">[SKU: <?php echo esc_html( $item['sku'] ); ?>]</span>
						<?php endif; ?>
					</td>
					<td class="col-hsn text-center"><?php echo ! empty( $hsn_code ) ? esc_html( $hsn_code ) : '-'; ?></td>
					<td class="col-qty text-center"><?php echo esc_html( $qty ); ?> Nos</td>
					<td class="col-rate text-right"><?php echo number_format( $rate, 2 ); ?></td>
					<td class="col-taxable text-right"><?php echo number_format( $item_taxable, 2 ); ?></td>
					<td class="col-gst-pc text-center"><?php echo $gst_rate > 0 ? esc_html( $gst_rate ) . '%' : '0%'; ?></td>
					<td class="col-gst-amt text-right"><?php echo number_format( $item_tax, 2 ); ?></td>
					<td class="col-total text-right"><?php echo number_format( $item_total, 2 ); ?></td>
				</tr>
			<?php endforeach; ?>

			<!-- Sub-Total Metrics Row -->
			<tr class="matrix-subtotal-row">
				<td colspan="3" class="text-right bold-text">Sub-Total:</td>
				<td class="text-center bold-text"><?php echo esc_html( $total_qty_counter ); ?></td>
				<td></td>
				<td class="text-right bold-text"><?php echo number_format( $total_taxable_counter, 2 ); ?></td>
				<td></td>
				<td class="text-right bold-text"><?php echo number_format( $total_tax_counter, 2 ); ?></td>
				<td class="text-right bold-text"><?php echo number_format( $total_gross_counter, 2 ); ?></td>
			</tr>
		</tbody>
	</table>

	<?php 
	// PRE-COMPUTE MATHEMATICAL METRICS PRIOR TO RENDERING LAYOUT COLUMNS
	$is_intrastate = true;
	if ( ! empty( $this->order ) ) {
		$state = $this->order->get_shipping_state() ? $this->order->get_shipping_state() : $this->order->get_billing_state();
		if ( ! in_array( strtoupper( $state ), [ 'TN', '33', 'TAMIL NADU', 'TAMILNADU' ] ) ) {
			$is_intrastate = false;
		}
	}

	$cgst_display = '-';
	$sgst_display = '-';
	$igst_display = '-';

	if ( $total_tax_counter > 0 ) {
		if ( $is_intrastate ) {
			$cgst_display = number_format( $total_tax_counter / 2, 2 );
			$sgst_display = number_format( $total_tax_counter / 2, 2 );
		} else {
			$igst_display = number_format( $total_tax_counter, 2 );
		}
	}

	$shipping = $this->order ? (float) $this->order->get_shipping_total() : 0;
	$raw_total = $total_gross_counter + $shipping;
	$final_rounded_total = round($raw_total, 0); 
	$round_difference = $final_rounded_total - $raw_total;
	?>

	<!-- Bottom Section Block -->
	<table class="footer-layout-table">
		<tr>
			<!-- Left Side: Banking Framework & Auto Word Generator -->
			<td class="footer-left-cell">
				<div class="bank-details-box">
					<div class="bank-box-title">Our Bank Details</div>
					<table class="bank-inner-table">
						<tr><th>Bank Name :</th><td>CANARA BANK</td></tr>
						<tr><th>Branch :</th><td>Abhiramapuram, Chennai 600018</td></tr>
						<tr><th>Account No :</th><td>0973201002215</td></tr>
						<tr><th>IFSC Code :</th><td>CNRB0000973</td></tr>
						<tr><th>UPI ID :</th><td>gajalaksh19-2@okaxis</td></tr>
					</table>
				</div>

				<div class="words-total-box">
					<strong>Invoice Total in Words:</strong><br>
					<span class="currency-words" style="text-transform: uppercase; font-weight: bold; color: #111;">
						Rupees <?php echo esc_html( satrendz_num_to_words( $final_rounded_total ) ); ?>
					</span>
				</div>
			</td>

			<!-- Right Side: Exact Tax Summary Table Component -->
			<td class="footer-right-cell">
				<table class="summary-calculation-matrix">
					<thead>
						<tr>
							<th>SUMMERY</th>
							<th class="text-right">AMOUNT</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<th>CGST Amt :</th>
							<td class="text-right"><?php echo esc_html( $cgst_display ); ?></td>
						</tr>
						<tr>
							<th>SGST Amt :</th>
							<td class="text-right"><?php echo esc_html( $sgst_display ); ?></td>
						</tr>
						<tr>
							<th>IGST Amt :</th>
							<td class="text-right"><?php echo esc_html( $igst_display ); ?></td>
						</tr>
						<tr>
							<th>Freight Packing Charges :</th>
							<td class="text-right"><?php echo $shipping > 0 ? number_format( $shipping, 2 ) : '-'; ?></td>
						</tr>
						<tr>
							<th>Round off :</th>
							<td class="text-right"><?php echo $round_difference != 0 ? number_format( $round_difference, 2 ) : '0.00'; ?></td>
						</tr>
						<tr class="grand-total-row-highlight">
							<th>Total Amount :</th>
							<td class="text-right"><?php echo number_format( $final_rounded_total, 2 ); ?></td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
	</table>

	<!-- Terms, Declaration, and Signatures Segment -->
	<table class="regulatory-footer-table">
		<tr>
			<td class="declaration-cell">
				<strong>Declaration</strong><br>
				1. Subject to local regional jurisdiction.<br>
				2. Terms & conditions are subject to our trade policy.<br>
				3. Our risk & responsibility ceases after the delivery of goods.<br>
				<span class="eoe-tag">E. & O.E.</span>
			</td>
			<td class="qr-cell">
				<?php
				// QR generation targeting the specified dynamic content wrapper URL
				$target_url = 'https://share.google/1qON6g969ctaVXCcq';
				$qr_api_endpoint = 'https://api.qrserver.com/v1/create-qr-code/?size=120x120&margin=0&data=' . urlencode($target_url);
				?>
				<img src="<?php echo esc_url($qr_api_endpoint); ?>" width="55" height="55" alt="Scan QR Code" style="display: block; margin: 0 auto; border: 1px solid #eaeaea; padding: 2px; background: #fff;" />
				<div style="font-size: 5.5pt; color: #444; margin-top: 4px; font-weight: bold; text-transform: uppercase; letter-spacing: 0.3px;">Scan Code</div>
			</td>
			<td class="signatory-cell">
				<div class="company-auth-title">For, <?php if ( method_exists( $this, 'shop_name' ) ) { $this->shop_name(); } else { echo "SATRENDZ"; } ?></div>
				<div class="auth-signature-line-gap"></div>
				<div class="auth-label">Authorised Signatory</div>
			</td>
		</tr>
	</table>

	<div class="thank-you-banner">Thank You For Business With US!</div>

</div>