<x-dynamic-component
    :component="$getFieldWrapperView()"
    :field="$field"
>
    <div
        x-data="{
            file: null,
            fileUrl: null,
            showCamera: false,
            stream: null,
            video: null,
            canvas: null,
            init() {
                this.video = this.$refs.video;
                this.canvas = this.$refs.canvas;
            },
            openCamera() {
                this.showCamera = true;
                navigator.mediaDevices.getUserMedia({
                    video: { facingMode: 'environment' }
                }).then(stream => {
                    this.stream = stream;
                    this.video.srcObject = stream;
                    this.video.play();
                }).catch(err => {
                    console.error('Error accessing camera:', err);
                    alert('Camera access denied or not available');
                    this.showCamera = false;
                });
            },
            captureImage() {
                const context = this.canvas.getContext('2d');
                this.canvas.width = this.video.videoWidth;
                this.canvas.height = this.video.videoHeight;
                context.drawImage(this.video, 0, 0);

                this.canvas.toBlob(blob => {
                    const file = new File([blob], 'captured-image.jpg', { type: 'image/jpeg' });
                    this.file = file;
                    this.fileUrl = URL.createObjectURL(file);
                    this.closeCamera();

                    // Trigger Filament's file upload by setting the state
                    $wire.set('{{ $getStatePath() }}', file);
                }, 'image/jpeg');
            },
            closeCamera() {
                this.showCamera = false;
                if (this.stream) {
                    this.stream.getTracks().forEach(track => track.stop());
                }
            }
        }"
        class="space-y-4"
    >
        <!-- Hidden file input for Filament -->
        <input
            x-ref="fileInput"
            type="file"
            accept="image/*"
            style="display: none;"
            @change="$wire.set($getStatePath(), $event.target.files[0])"
        />

        <!-- Camera Button -->
        <button
            type="button"
            @click="openCamera()"
            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150"
        >
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
            </svg>
            Ambil Gambar
        </button>

        <!-- Camera Modal -->
        <div
            x-show="showCamera"
            x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
            @keydown.escape.window="closeCamera()"
        >
            <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Ambil Gambar</h3>
                    <button @click="closeCamera()" class="text-gray-500 hover:text-gray-700">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <video x-ref="video" class="w-full h-64 bg-black rounded" autoplay muted></video>
                <canvas x-ref="canvas" class="hidden"></canvas>

                <div class="flex justify-center mt-4 space-x-2">
                    <button
                        @click="captureImage()"
                        class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700"
                    >
                        Ambil
                    </button>
                    <button
                        @click="closeCamera()"
                        class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700"
                    >
                        Batal
                    </button>
                </div>
            </div>
        </div>

        <!-- Preview -->
        <div x-show="fileUrl" x-cloak class="mt-4">
            <img :src="fileUrl" class="max-w-xs rounded shadow" />
        </div>
    </div>
</x-dynamic-component>
