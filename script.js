document.getElementById('saveButton').addEventListener('click', function() {
    alert('保存功能尚未实现');
});

document.getElementById('exportButton').addEventListener('click', function() {
    const formData = new FormData(document.getElementById('dataEntryForm'));

    fetch('generate_pdf.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.blob())
    .then(blob => {
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.style.display = 'none';
        a.href = url;
        a.download = '生产指令单.pdf';
        document.body.appendChild(a);
        a.click();
        window.URL.revokeObjectURL(url);
        document.getElementById('responseMessage').textContent = 'PDF文件已生成并下载。';
    })
    .catch(error => {
        document.getElementById('responseMessage').textContent = 'Error: ' + error.message;
    });
});

function previewImage(input, previewElement) {
    const file = input.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewElement.src = e.target.result;
            previewElement.style.display = 'block';
        }
        reader.readAsDataURL(file);
    }
}

for (let i = 1; i <= 16; i++) {
    document.getElementById(`upload${i}`).addEventListener('change', function(e) {
        previewImage(e.target, document.getElementById(`preview${i}`));
    });
}

document.getElementById('adapter').addEventListener('change', function(e) {
    const otherInput = document.getElementById('adapterOther');
    if (e.target.value === '其他') {
        otherInput.style.display = 'block';
    } else {
        otherInput.style.display = 'none';
    }
});
