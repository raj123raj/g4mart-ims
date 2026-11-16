# Suggested manual test cases

| ID | Test | Expected result |
|---|---|---|
| TC01 | Add a product with valid details | Product is saved and appears in list |
| TC02 | Add a duplicate SKU | Validation message is displayed |
| TC03 | Submit a negative price | Validation rejects the value |
| TC04 | Submit a negative quantity | Validation rejects the value |
| TC05 | Edit an existing product | Updated details appear in list |
| TC06 | Delete a product | Product is removed from list |
| TC07 | Search by full/partial name | Matching product is displayed |
| TC08 | Search by SKU | Matching product is displayed |
| TC09 | Search for unknown product | No products found message appears |
| TC10 | Set quantity at/below reorder level | Product appears in low-stock alerts |
| TC11 | Open dashboard | Product count, total quantity and low-stock count display |

Record actual outcomes and screenshots during testing. Do not report expected outcomes as actual results unless you have run the tests.
