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
