@extends('layouts/app')


@section('content')
    <button id="scanner-form">
        toggle scanner
    </button>
    <button id="qr-scanner-closer">
        close scanner
    </button>
    <input type="file" id="target-file-QR">
    <div id="scanner"></div>
    <div id="reader"></div>
    <div id="result"></div>
@endsection



@section('script')
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
@endsection

@section('script2')
    <script>
        const qrCodeScanner = new Html5Qrcode('scanner');
        const QRscanning = async () => {
            await Html5Qrcode.getCameras().then(async (devices) => {
                const config = {

                    fps: 15, // Set the capture frame rate to 15 FPS.
                    qrbox: 150, // Set the QR code scanning box size to 300 pixels.
                    aspectRatio: 1.5 // Set the aspect ratio of the QR code scanning box to 1.5.
                };
                
                const onSuccess = async (decodedText, decodedResult) => {
                    if (decodedText.startsWith('https://coolmate.me')) {
                        qrCodeScanner.stop().then((ignore) => {
                            console.log(decodedResult);
                            window.location.href = decodedText;
                        }).catch((err) => {
                            // Stop failed, handle it.
                            console.log(err);
                        });
                    }

                }
                const onError = (err) => {
                    console.warn(err);
                }
                document.getElementById('result').innerHTML = devices.map(e => e.label).join(',');
                if (devices.length > 1) {
                    await qrCodeScanner.start({ facingMode: "environment" }, config, onSuccess, onError);
                }
                else 
                    await qrCodeScanner.start(devices[0].id, config, onSuccess, onError);
            }).catch(err => {
                // handle err
                console.warn(err)
            });

        }
        $(document).ready(() => {
            const scannerToggler = document.getElementById('scanner-form');
            scannerToggler.addEventListener('click', async () => {
                try {
                    await QRscanning();
                } catch (e) {
                    console.log(e);
                }
            });
            const fileinput = document.getElementById('target-file-QR');
            fileinput.addEventListener('change', async (e) => {
                await readFileQR(e);
            })
            const closer = document.getElementById('qr-scanner-closer');
            closer.addEventListener('click', async() => {
                    await qrCodeScanner.stop();
                })
        });
        const readFileQR = async (e) => {
            const html5QrCode = new Html5Qrcode( /* element id */ "reader");
            const imageFile = e.target.files[0];
            // Scan QR Code
            html5QrCode.scanFile(imageFile, true)
                .then(decodedText => {
                    // success, use decodedText
                    window.location.href = decodedText;
                })
                .catch(err => {
                    // failure, handle it.
                    console.log(`Error scanning file. Reason: ${err}`)
                });
        }
    </script>
@endsection
