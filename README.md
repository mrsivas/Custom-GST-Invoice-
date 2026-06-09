# WooCommerce Custom PDF Invoice & Packing Slip (Indian GST Ready)

A set of custom, professional PHP templates designed for WooCommerce. These templates override the default PDF invoice and packing slip layouts, offering a highly structured, matrix-style design specifically tailored for Indian e-commerce businesses. 

## 🚀 Features

### Invoice Template (`invoice.php`)
* **Indian GST Compliance:** Automatically calculates and displays CGST and SGST for intra-state shipping (Tamil Nadu configured as default), or IGST for inter-state shipping.
* **Custom Number-to-Words Converter:** Includes a standalone PHP function (`satrendz_num_to_words`) that converts the final invoice total into words using the Indian numbering system (Lakhs, Crores).
* **Dynamic QR Code Integration:** Automatically generates a scannable QR code linking to a designated URL via the QR Server API.
* **Itemized Matrix Layout:** Clean table structure displaying HSN codes, Taxable Amount, GST percentages, and line-item totals.
* **Bank Details & Declarations:** Pre-formatted sections for banking information (NEFT/UPI) and standard trade declarations.

### Packing Slip Template (`packing-slip.php`)
* **Logistics Focused:** Strips out all financial data, pricing, and tax information, focusing purely on what the fulfillment team and customer need to verify the physical goods.
* **Unified Aesthetics:** Shares the same professional table structures, fonts, and branding as the invoice for a cohesive customer unboxing experience.
* **Clear Quantity Matrix:** Highlights SKUs and item quantities for easy quality control (QC) checking.

## 📂 File Structure

```text
├── invoice.php         # The master tax invoice template
├── packing-slip.php    # The financial-free packing slip template
└── README.md           # Documentation

```


🛠️ Installation & Usage
These templates are designed to be used with standard WooCommerce PDF Invoices & Packing Slips plugins (like the one by WP Overnight).

To safely override the default templates without losing your changes during a plugin update:

Connect to your WordPress site via FTP or your hosting file manager.

Navigate to your active child theme (or main theme):
wp-content/themes/your-active-theme/

Create the following directory structure if it doesn't already exist:
woocommerce/pdf/custom-satrendz/

Upload invoice.php and packing-slip.php into this new folder.

Go to your WordPress Admin Dashboard -> WooCommerce -> PDF Invoices.

Under the General tab, look for the "Choose a template" setting and select your new custom-satrendz template.

⚙️ Configuration Notes
GSTIN & HSN Codes: Ensure your WooCommerce products have custom meta fields for _satrendz_gst_percentage and _satrendz_hsn_code for the matrix to populate correctly.

Intra-state Tax Logic: By default, the script checks if the shipping state is TN or Tamil Nadu to split the tax into CGST/SGST. You can modify this in the invoice.php file on line 197.

Bank Info: Update the hardcoded bank account and UPI details in the invoice.php footer segment to match your business accounts.

👨‍💻 Author
Sivaraj Shanmugam
PHP / DevOps & Site Reliability Engineering

📄 License
This project is open-source and available under the MIT License.



***

### A few quick tips before you commit:
* **The State Check:** Just a reminder that on line 197 of the `invoice.php` file, the state logic is currently set to `TN` and `Tamil Nadu` to trigger the CGST/SGST split. 
* **Custom Meta Fields:** The invoice looks for `_satrendz_gst_percentage` and `_satrendz_hsn_code`. If you are using a specific GST plugin for WooCommerce, you might want to swap those meta keys out in the PHP file to match the keys your plugin uses


