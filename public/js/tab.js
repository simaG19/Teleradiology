
    document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('upload-form');
    const fileInput = document.getElementById('archive-input');
    const progressContainer = document.getElementById('progress-container');
    const progressBar = document.getElementById('upload-progress');
    const statusText = document.getElementById('upload-status');
    const submitButton = document.getElementById('upload-button');

    form.addEventListener('submit', function (e) {
        e.preventDefault();
        if (!fileInput.files.length) return;

        submitButton.disabled = true;
        submitButton.innerText = 'Uploading...';

        progressContainer.style.display = 'block';
        progressBar.value = 0;
        statusText.innerText = '0%';

        const formData = new FormData();
        formData.append('_token', document.querySelector('input[name="_token"]').value);
        formData.append('archive', fileInput.files[0]);

        const xhr = new XMLHttpRequest();
        xhr.open('POST', form.getAttribute('action'), true);

        xhr.upload.addEventListener('progress', function (event) {
            if (event.lengthComputable) {
                const percentComplete = Math.round((event.loaded / event.total) * 100);
                progressBar.value = percentComplete;
                statusText.innerText = percentComplete + '%';
            }
        });

        xhr.addEventListener('load', function () {
            console.log('XHR LOAD → status:', xhr.status);
            console.log('XHR Response:', xhr.responseText);

            if (xhr.status >= 200 && xhr.status < 300) {
                progressBar.value = 100;
                statusText.innerText = 'Upload complete!';

                let resp;
                try {
                    resp = JSON.parse(xhr.responseText);
                } catch (err) {
                    resp = { message: 'Unexpected JSON parse error' };
                }

                statusText.innerText = resp.message || 'Upload succeeded';

                setTimeout(() => {
                    submitButton.disabled = false;
                    submitButton.innerText = 'Upload & Extract';
                    progressContainer.style.display = 'none';
                    progressBar.value = 0;
                    statusText.innerText = '';
                    form.reset();
                }, 1500);
            } else {
                // Validation or redirect landed here
                submitButton.disabled = false;
                submitButton.innerText = 'Upload & Extract';
                let errMsg = 'Upload failed. Please try again.';
                try {
                    const errResp = JSON.parse(xhr.responseText);
                    if (errResp.message) {
                        errMsg = errResp.message;
                    }
                } catch (_) {}
                statusText.innerText = `Error ${xhr.status}: ${errMsg}`;
            }
        });

        xhr.addEventListener('error', function () {
            console.log('XHR NETWORK ERROR', xhr.status, xhr.responseText);
            submitButton.disabled = false;
            submitButton.innerText = 'Upload & Extract';
            statusText.innerText = 'Network error. Please try again.';
        });

        xhr.send(formData);
    });
});

