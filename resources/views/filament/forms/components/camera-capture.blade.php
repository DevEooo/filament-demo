{{-- resources/views/filament/forms/components/camera-capture.blade.php --}}

<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    <div x-data="{
        state: $wire.entangle('{{ $getStatePath() }}'),
        stream: null,
        capturedImage: null,
        init() {
            // Check for existing state (e.g., if editing)
            if (this.state) {
                this.capturedImage = '{{ asset('storage') }}' + '/' + this.state;
            }
        },
        startCamera() {
            navigator.mediaDevices.getUserMedia({ video: true, audio: false })
                .then(stream => {
                    this.stream = stream;
                    this.$refs.video.srcObject = stream;
                })
                .catch(error => {
                    alert('Tidak dapat mengakses kamera: ' + error.message);
                    console.error('Kamera Error:', error);
                });
        },
        stopCamera() {
            if (this.stream) {
                this.stream.getTracks().forEach(track => track.stop());
                this.stream = null;
            }
        },
        captureImage() {
            const video = this.$refs.video;
            const canvas = this.$refs.canvas;
            
            // Set canvas dimensions to match video stream
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            
            const context = canvas.getContext('2d');
            context.drawImage(video, 0, 0, canvas.width, canvas.height);
            
            // Get data URL (Base64)
            const imageData = canvas.toDataURL('image/png');
            this.capturedImage = imageData;
            
            // Stop camera stream after capturing
            this.stopCamera();
            
            // Send Base64 data to Livewire component for saving
            $wire.call('saveFile', imageData).then(path => {
                this.state = path;
            });
        }
    }" 
    x-on:close.stop="stopCamera()">
    
        <div class="space-y-4 p-4 border border-gray-300 rounded-lg">
            
            {{-- Camera Feed and Controls --}}
            <template x-if="!capturedImage">
                <div class="flex flex-col items-center space-y-3">
                    <video x-ref="video" autoplay class="w-full rounded-md shadow-lg max-h-80"></video>
                    <canvas x-ref="canvas" style="display: none;"></canvas>
                    
                    <div class="flex space-x-2">
                        <x-filament::button color="gray" x-on:click="startCamera" x-show="!stream" icon="heroicon-o-video-camera">
                            Buka Kamera
                        </x-filament::button>
                        
                        <x-filament::button color="danger" x-on:click="stopCamera" x-show="stream" icon="heroicon-o-stop">
                            Tutup Kamera
                        </x-filament::button>
                        
                        <x-filament::button color="primary" x-on:click="captureImage" x-show="stream" icon="heroicon-o-camera">
                            Ambil Gambar
                        </x-filament::button>
                    </div>
                </div>
            </template>

            {{-- Captured Image Preview --}}
            <template x-if="capturedImage">
                <div class="flex flex-col items-center space-y-3">
                    <img :src="capturedImage" alt="Captured Image Preview" class="w-full rounded-md shadow-lg max-h-80">
                    
                    <div class="flex space-x-2">
                        <x-filament::button color="warning" x-on:click="capturedImage = null; state = null; startCamera()" icon="heroicon-o-arrow-path">
                            Ambil Ulang
                        </x-filament::button>
                        
                        <p class="text-sm text-gray-500 italic">Gambar siap diunggah.</p>
                    </div>
                </div>
            </template>
        </div>
    </div>
</x-dynamic-component>