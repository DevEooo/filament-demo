# TODO: Fix Invoice Table and Relationships

- [x] Create migration to add 'faktur_id' foreign key and 'deleted_at' column to 'invoice' table
- [x] Update Invoice model to fix belongsTo relationship with Faktur
- [x] Update FakturResource form to add 'qty' field in the invoice Repeater
- [ ] Run the migration to update the database
- [ ] Test the application to ensure the error is fixed
