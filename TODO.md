# TODO: Fix Upload Gambar and Lihat Data Upload Pages

- [x] Remove unused table() method from UploadResource.php to ensure no table on "Upload Gambar" page
- [x] Modify resources/views/filament/tables/columns/upload-images.blade.php to make images downloadable by wrapping <img> in <a href> with download attribute
- [x] Add both upload and camera capture fields: "Upload Gambar" for file picker and "Ambil Gambar" for camera
- [x] Create custom CameraCapture component with JavaScript camera access using getUserMedia
- [x] Use existing Upload model with both uploaded_image and captured_image fields
- [x] Database table already exists with required columns
- [x] Implementation completed - "Upload Gambar" page now has file upload and camera capture functionality
- [x] "Lihat Data Upload" page displays both image types with download options
