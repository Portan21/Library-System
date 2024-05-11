var qrText = document.getElementById('qr-name').innerHTML;


qrcode.src="https://api.qrserver.com/v1/create-qr-code/?size=[250]x[250]&data=" + qrText;


