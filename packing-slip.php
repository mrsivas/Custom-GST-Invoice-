<?php 
if ( ! defined( 'ABSPATH' ) ) exit; 
?>

<div class="packing-slip-master-box">

	<!-- Top Title Bar Segment -->
	<table class="title-bar-table">
		<tr>
			<td class="left-title">PACKING SLIP</td>
			<td class="right-title">Order #<?php if ( method_exists( $this, 'order_number' ) ) { $this->order_number(); } ?></td>
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
					echo '<div style="font-size: 32px;">📦</div>';
				}
				?>
			</td>
			<td class="vendor-details-cell">
				<div class="vendor-name"><?php if ( method_exists( $this, 'shop_name' ) ) { $this->shop_name(); } else { echo "SATRENDZ"; } ?></div>
				<div class="vendor-address">
					<?php if ( method_exists( $this, 'shop_address' ) ) { $this->shop_address(); } else { echo "Online Fashion & Dance Gear Hub, Tamil Nadu, India"; } ?>
				</div>
				<div style="font-size: 12px; color: #555; margin-top: 5px;">
					Email: gajalaksh19@gmail.com | Phone: +91 8754531686
				</div>
			</td>
		</tr>
	</table>

	<!-- Split Metadata Row: Left (Addresses) vs Right (Logistics Grid) -->
	<table class="split-metadata-table">
		<tr>
			<!-- Left Column: Ship To & Bill To Boxes -->
			<td class="address-side-cell">
				<!-- Ship To Sub-Box (Prioritized for Packing Slips) -->
				<div class="address-block-header">Ship To (Delivery Address)</div>
				<div class="address-block-body">
					<strong>Name :</strong> <?php if ( $this->order ) { echo esc_html( $this->order->get_shipping_first_name() . ' ' . $this->order->get_shipping_last_name() ); } ?><br>
					<strong>Address :</strong> <?php if ( method_exists( $this, 'needs_shipping_address' ) && $this->needs_shipping_address() && method_exists( $this, 'shipping_address' ) ) { $this->shipping_address(); } else { if ( method_exists( $this, 'billing_address' ) ) { $this->billing_address(); } } ?><br>
					<strong>State :</strong> <?php if ( $this->order ) { echo esc_html( $this->order->get_shipping_state() ? $this->order->get_shipping_state() : $this->order->get_billing_state() ); } ?><br>
					<strong>Phone :</strong> <?php if ( $this->order ) { echo esc_html( $this->order->get_billing_phone() ); } ?>
				</div>

				<!-- Bill To Sub-Box -->
				<div class="address-block-header border-top-divider">Billing Details</div>
				<div class="address-block-body">
					<strong>Name :</strong> <?php if ( $this->order ) { echo esc_html( $this->order->get_billing_first_name() . ' ' . $this->order->get_billing_last_name() ); } ?><br>
					<strong>Email :</strong> <?php if ( $this->order ) { echo esc_html( $this->order->get_billing_email() ); } ?>
				</div>
			</td>

			<!-- Right Column: Structured Line Grid -->
			<td class="grid-side-cell">
				<table class="logistics-inner-grid">
					<tr>
						<th>Order Number :</th>
						<td>#<?php if ( method_exists( $this, 'order_number' ) ) { $this->order_number(); } ?></td>
					</tr>
					<tr>
						<th>Order Date :</th>
						<td><?php if ( method_exists( $this, 'order_date' ) ) { $this->order_date(); } ?></td>
					</tr>
					<tr>
						<th>Shipping Method :</th>
						<td><?php echo method_exists( $this->order, 'get_shipping_method' ) ? esc_html( $this->order->get_shipping_method() ) : 'Standard'; ?></td>
					</tr>
					<tr>
						<th>Customer Note :</th>
						<td><?php echo $this->order && $this->order->get_customer_note() ? esc_html( $this->order->get_customer_note() ) : 'None'; ?></td>
					</tr>
					<tr>
						<th>Total Weight :</th>
						<td>-</td>
					</tr>
					<tr>
						<th>Box Count :</th>
						<td>_____ of _____</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>

	<!-- Itemized Grid (Quantities Only) -->
	<table class="order-details-matrix">
		<thead>
			<tr>
				<th class="col-sr">Sr</th>
				<th class="col-desc">Product Description</th>
				<th class="col-sku">SKU</th>
				<th class="col-qty">Quantity</th>
			</tr>
		</thead>
		<tbody>
			<?php 
			$items = method_exists( $this, 'get_order_items' ) ? $this->get_order_items() : [];
			$sr = 1;
			$total_qty_counter = 0;

			foreach ( $items as $item_id => $item ) : 
				$wc_item = isset( $item['item'] ) ? $item['item'] : null;
				$qty = 0;
				
				if ( $wc_item instanceof WC_Order_Item_Product ) {
					$qty = (int) $wc_item->get_quantity();
				}
				$total_qty_counter += $qty;
			?>
				<tr>
					<td class="col-sr text-center"><?php echo esc_html( $sr++ ); ?></td>
					<td class="col-desc">
						<span class="item-main-name"><?php echo esc_html( $item['name'] ?? '' ); ?></span>
						<?php 
						// Display item meta (e.g., variations like size, color)
						if ( ! empty( $item['meta'] ) ) {
							echo '<span class="item-meta">' . wp_kses_post( $item['meta'] ) . '</span>';
						}
						?>
					</td>
					<td class="col-sku text-center"><?php echo ! empty( $item['sku'] ) ? esc_html( $item['sku'] ) : '-'; ?></td>
					<td class="col-qty text-center" style="font-size: 16px;"><?php echo esc_html( $qty ); ?></td>
				</tr>
			<?php endforeach; ?>

			<!-- Sub-Total Metrics Row -->
			<tr style="background: #f8f9fa;">
				<td colspan="3" style="text-align: right; font-weight: bold; padding: 10px;">Total Items to Pack:</td>
				<td class="text-center" style="font-weight: bold; font-size: 18px;"><?php echo esc_html( $total_qty_counter ); ?></td>
			</tr>
		</tbody>
	</table>

	<!-- Terms, Declaration, and Signatures Segment -->
	<table class="regulatory-footer-table">
		<tr>
			<td class="declaration-cell">
				<strong>Important Note for Customer:</strong><br>
				Please check the contents of this package against this packing slip immediately upon receipt. If there are any discrepancies, please contact our support team at gajalaksh19@gmail.com within 48 hours. Prices and tax details have been omitted from this slip; please refer to your digital invoice for billing records.
			</td>
			<td class="qr-cell">
				<?php
				// Reusing your specific QR Code
				$target_url = 'https://share.google/1qON6g969ctaVXCcq';
				$qr_api_endpoint = 'https://api.qrserver.com/v1/create-qr-code/?size=120x120&margin=0&data=' . urlencode($target_url);
				?>
				<img src="<?php echo esc_url($qr_api_endpoint); ?>" width="65" height="65" alt="Scan QR Code" style="display: block; margin: 0 auto; border: 1px solid #eaeaea; padding: 2px; background: #fff;" />
				<div style="font-size: 6pt; color: #444; margin-top: 4px; font-weight: bold; text-transform: uppercase;">Scan Code</div>
			</td>
			<td class="signatory-cell">
				<div class="auth-signature-line-gap"></div>
				<div class="auth-label">Packed By / QC Checked</div>
			</td>
		</tr>
	</table>

	<div class="thank-you-banner">Thank You For Shopping With SATRENDZ!</div>

</div>