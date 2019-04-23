<?php if (!defined('ABSPATH')) {
    exit;
}
// Exit if accessed directly ?>
<?php do_action('wpo_wcpdf_before_document', $this->type, $this->order);?>

<table class="head container">
	<tr>
		<td class="header">
		<?php
if ($this->has_header_logo()) {
    $this->header_logo();
} else {
    echo $this->get_title();
}
?>
		</td>
		<td class="shop-info">
			<div class="shop-name"><h3><?php $this->shop_name();?></h3></div>
			<div class="shop-address"><?php $this->shop_address();?></div>
			<div class="shop-vat">USt-ID: DE311874101</div>
		</td>
	</tr>
</table>

<h1 class="document-type-label">
<?php if ($this->has_header_logo()) {
    echo $this->get_title();
}
?>
</h1>

<?php do_action('wpo_wcpdf_after_document_label', $this->type, $this->order);?>

<table class="order-data-addresses">
	<tr>
		<td class="address billing-address">
			<!-- <h3><?php _e('Billing Address:', 'woocommerce-pdf-invoices-packing-slips');?></h3> -->
			<?php do_action('wpo_wcpdf_before_billing_address', $this->type, $this->order);?>
			<?php $this->billing_address();?>
			<?php do_action('wpo_wcpdf_after_billing_address', $this->type, $this->order);?>
			<?php if (isset($this->settings['display_email'])) {?>
			<div class="billing-email"><?php $this->billing_email();?></div>
			<?php }?>
			<?php if (isset($this->settings['display_phone'])) {?>
			<div class="billing-phone"><?php $this->billing_phone();?></div>
			<?php }?>
		</td>
		<td class="address shipping-address">
			<?php if (isset($this->settings['display_shipping_address']) && $this->ships_to_different_address()) {?>
			<h3><?php _e('Ship To:', 'woocommerce-pdf-invoices-packing-slips');?></h3>
			<?php do_action('wpo_wcpdf_before_shipping_address', $this->type, $this->order);?>
			<?php $this->shipping_address();?>
			<?php do_action('wpo_wcpdf_after_shipping_address', $this->type, $this->order);?>
			<?php }?>
		</td>
		<td class="order-data">
			<table>
				<?php do_action('wpo_wcpdf_before_order_data', $this->type, $this->order);?>
				<?php if (isset($this->settings['display_number'])) {?>
				<tr class="invoice-number">
					<th><?php _e('Invoice Number:', 'woocommerce-pdf-invoices-packing-slips');?></th>
					<td><?php $this->invoice_number();?></td>
				</tr>
				<?php }?>
				<?php if (isset($this->settings['display_date'])) {?>
				<tr class="invoice-date">
					<th><?php _e('Invoice Date:', 'woocommerce-pdf-invoices-packing-slips');?></th>
					<td><?php $this->invoice_date();?></td>
				</tr>
                <?php }?>

                <?php if (false) { ?>
				<tr class="order-number">
					<th><?php _e('Order Number:', 'woocommerce-pdf-invoices-packing-slips');?></th>
					<td><?php $this->order_number();?></td>
				</tr>
				<tr class="order-date">
					<th><?php _e('Order Date:', 'woocommerce-pdf-invoices-packing-slips');?></th>
					<td><?php $this->order_date();?></td>
				</tr>
				<tr class="payment-method">
					<th><?php _e('Payment Method:', 'woocommerce-pdf-invoices-packing-slips');?></th>
					<td><?php $this->payment_method();?></td>
                </tr>
                <?php }?>

				<?php do_action('wpo_wcpdf_after_order_data', $this->type, $this->order);?>
			</table>
		</td>
	</tr>
</table>

<?php do_action('wpo_wcpdf_before_order_details', $this->type, $this->order);?>

<table class="order-details">
	<thead>
		<tr>
			<th class="product"><?php _e('Product', 'woocommerce-pdf-invoices-packing-slips');?></th>
			<th class="quantity"><?php _e('Quantity', 'woocommerce-pdf-invoices-packing-slips');?></th>
			<th class="price"><?php _e('Price', 'woocommerce-pdf-invoices-packing-slips');?></th>
		</tr>
	</thead>
	<tbody>
		<?php $items = $this->get_order_items();if (sizeof($items) > 0): foreach ($items as $item_id => $item): ?>
        <tr class="<?php echo apply_filters('wpo_wcpdf_item_row_class', $item_id, $this->type, $this->order, $item_id); ?>">
            <td class="product">
                <?php $description_label = __('Description', 'woocommerce-pdf-invoices-packing-slips'); // registering alternate label translation ?>
                <span class="item-name"><?php echo $item['name']; ?></span>
                <?php do_action('wpo_wcpdf_before_item_meta', $this->type, $item, $this->order);?>
                <span class="item-meta"><?php echo $item['meta']; ?></span>
                <dl class="meta">
                    <?php $description_label = __('SKU', 'woocommerce-pdf-invoices-packing-slips'); // registering alternate label translation ?>
                    <?php if (!empty($item['sku'])): ?><dt class="sku"><?php _e('SKU:', 'woocommerce-pdf-invoices-packing-slips');?></dt><dd class="sku"><?php echo $item['sku']; ?></dd><?php endif;?>
                <?php if (!empty($item['weight'])): ?><dt class="weight"><?php _e('Weight:', 'woocommerce-pdf-invoices-packing-slips');?></dt><dd class="weight"><?php echo $item['weight']; ?><?php echo get_option('woocommerce_weight_unit'); ?></dd><?php endif;?>
                </dl>
                <?php do_action('wpo_wcpdf_after_item_meta', $this->type, $item, $this->order);?>
            </td>
            <td class="quantity"><?php echo $item['quantity']; ?></td>
            <td class="price"><?php echo $item['order_price']; ?></td>
        </tr>
		<?php endforeach;endif;?>
	</tbody>
	<tfoot>
		<tr class="no-borders">
			<td class="no-borders">
				<div class="customer-notes">
					<?php do_action('wpo_wcpdf_before_customer_notes', $this->type, $this->order);?>
					<?php if ($this->get_shipping_notes()): ?>
						<h3><?php _e('Customer Notes', 'woocommerce-pdf-invoices-packing-slips');?></h3>
						<?php $this->shipping_notes();?>
					<?php endif;?>
					<?php do_action('wpo_wcpdf_after_customer_notes', $this->type, $this->order);?>
				</div>
			</td>
			<td class="no-borders" colspan="2">
				<table class="totals">
					<tfoot>
						<?php foreach ($this->get_woocommerce_totals() as $key => $total): ?>
						<tr class="<?php echo $key; ?>">
							<td class="no-borders"></td>
							<th class="description"><?php echo $total['label']; ?></th>
							<td class="price"><span class="totals-price"><?php echo $total['value']; ?></span></td>
						</tr>
						<?php endforeach;?>
					</tfoot>
				</table>
			</td>
		</tr>
	</tfoot>
</table>

<?php do_action('wpo_wcpdf_after_order_details', $this->type, $this->order);?>

<hr></br>

<div class="ticket ym-grid ym-equalize">
    <section class="ticket__information ym-g33 ym-gl">
        <div class="ym-gbox">
            <h2 class="uppercase">Gebucht von</h2>
            <ul class="ticket__customer">
                <li><strong>Name: </strong><?php echo get_post_meta($this->order->get_id(), 'customer--name', true); ?></li>
                <li><strong>Telefon: </strong><?php echo get_post_meta($this->order->get_id(), 'customer--phone', true); ?></li>
                <li><strong>eMail: </strong><?php echo get_post_meta($this->order->get_id(), 'customer--email', true); ?></li>
            </ul>
        </div>
    </section>

    <section class="ticket__information ticket__card ym-g66 ym-gr">
        <div class="ym-gbox">
            <h2>TICKETS</h2>
            <p><span class="bold">Hiermit erhaltet ihr offiziell Zutritt zur dunklen Seite der Stadt Berlin!</span><br><br>
                Aber nur, wenn ihr euch traut. Denn ihr werdet in eine Welt voller düsterer Legenden, gruseliger Geheimnisse aus der Vergangenheit und Furcht einflößender Begebenheiten entführt!
            </p><br>

            <?php foreach ($this->get_order_items() as $item_id => $item) {?>
            <article class="ticket__data">
                <ul>
                    <li class="uppercase"><strong><?php echo $item['name']; ?></strong></li>
                    <li><strong>PERSONEN: </strong><?php echo $item['quantity']; ?></li>
                    <li><strong>TICKETNUMMER: </strong><?php echo $this->invoice_number(); ?></li>
                </ul>
            </article>
            <?php }?>
        </div>
    </section>
</div>

<div class="ticket ym-grid ym-equalize">
    <section class="ticket__information ym-g33 ym-gl">
        <div class="ym-gbox">
            <h2>TREFFPUNKT</h2>
            <p class="blocktext">Der Treffpunkt befindet sich vor der Klosterruine am U-Bahnhof Klosterstraße. Direkt hinter dem Alexa.
                <br />
                <span class="bold">Ruine der Franziskaner-Klosterkirche, Klosterstraße 73a, 10179 Berlin</span>
            </p>
        </div>
    </section>

    <section class="ticket__information ym-g33 ym-gl">
        <div class="ym-gbox">
            <h2>INFORMATIONEN</h2>
            <article>
                <ul class="ticket__tips">
                    <li>Die Tour dauert 90 Minuten.</li>
                    <li>Wir legen während der Tour 1,5km zu Fuß zurück.</li>
                    <li>Wir laufen zum Teil über Kopfsteinpflaster.</li>
                    <li>Die Tour findet bei Wind und Wetter draußen statt. Wir finden aber ab und zu Plätze zum Unterstellen.</li>
                    <!-- <li>Parken</li>
                    <li>Toilette</li> -->
                </ul>
            </article>
        </div>
    </section>

    <section class="ticket__information ym-g33 ym-gr">
        <div class="ym-gbox">
            <h2>KONTAKT</h2>
            <p>
                <ul class="ticket__contact">
                    <li>Telefon, WhatsApp, Telegram, Threema, Signal: +49 176 569 718 64</li>
                    <li>Mail: kontakt@gruseltour-berlin.de</li>
                </ul>
            </p>
        </div>
    </section>
</div>

<?php if ($this->get_footer()): ?>
<div id="footer">
	<?php $this->footer();?>
</div><!-- #letter-footer -->
<?php endif;?>

<footer>
        <p>
            <ul class="footer__socialmedia ym-clearfix">
                <li>Facebook @GruseltourBerlin</li>
                <li>Instagram @Gruseltour</li>
                <li>Twitter @Gruseltour</li>
                <li>Tripadvisor Gruseltour Berlin</li>
            </ul>
        </p>
    </footer>

<?php do_action('wpo_wcpdf_after_document', $this->type, $this->order);?>
