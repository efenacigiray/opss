function updateBarcode() {
    var barcode = new bytescoutbarcode128();
    var value = document.getElementById("barcodeValue").value;

    barcode.valueSet(value);
    barcode.setMargins(5, 5, 5, 5);
    barcode.setBarWidth(2);
    var width = barcode.getMinWidth();
    barcode.setSize(width, 115);
    var barcodeImage = document.getElementById('barcodeImage');
    barcodeImage.src = barcode.exportToBase64(width, 115, 0);
}

function saveBarcode() {
    document.frmSaveBarcode.barcodeBase64.value = document.getElementById('barcodeImage').src;
    document.frmSaveBarcode.submit();
}

function Imprimir(a) {
    var b = document.getElementById(a).innerHTML, c = document.body.innerHTML;
    document.body.innerHTML = b, window.print(), document.body.innerHTML = c
}