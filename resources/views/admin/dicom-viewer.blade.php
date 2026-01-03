<x-admin-lay>
  <x-slot name="header">
    <h2 class="text-xl font-semibold">DICOM Viewer</h2>
  </x-slot>

  <div class="p-6">
    <div id="dicomImage"
         style="width:512px; height:512px; border:1px solid black;"></div>

    <input type="file" id="fileInput" accept=".dcm" class="mt-4" />
  </div>

  @push('scripts')
    <script src="https://unpkg.com/cornerstone-core@2.4.0/dist/cornerstone.min.js"></script>
    <script src="https://unpkg.com/cornerstone-wado-image-loader@4.0.1/dist/cornerstoneWADOImageLoader.min.js"></script>
    <script src="https://unpkg.com/dicom-parser@1.8.4/dist/dicomParser.min.js"></script>

    <script>
      cornerstoneWADOImageLoader.external.cornerstone = cornerstone;
      cornerstoneWADOImageLoader.webWorkerManager.initialize({
        webWorkerPath: 'https://unpkg.com/cornerstone-wado-image-loader@4.0.1/dist/cornerstoneWADOImageLoaderWebWorker.min.js',
        taskConfiguration: {
          decodeTask: {
            codecsPath: 'https://unpkg.com/cornerstone-wado-image-loader@4.0.1/dist/cornerstoneWADOImageLoaderCodecs.min.js'
          }
        }
      });

      const element = document.getElementById('dicomImage');
      cornerstone.enable(element);

      document.getElementById('fileInput').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const imageId = cornerstoneWADOImageLoader.wadouri.fileManager.add(file);
        cornerstone.loadImage(imageId).then(function(image) {
          cornerstone.displayImage(element, image);
        });
      });
    </script>
  @endpush
</x-admin-lay>
