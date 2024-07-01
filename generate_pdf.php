<?php
require_once('tcpdf/tcpdf.php'); // 引入TCPDF库

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // 获取表单数据
    $customerCode = $_POST['customerCode'];
    $orderNumber = $_POST['orderNumber'];
    $quantity = $_POST['quantity'];
    $model = $_POST['customerModel'];
    $color = $_POST['color'];
    $country = $_POST['country'];
    $completionDate = $_POST['completionDate'];
    $notes = $_POST['notes'];
    $internalModel = $_POST['internalModel'];
    $sewingRequirements = $_POST['sewingRequirements'];
    $adapter = $_POST['adapter'];
    $adapterOther = $_POST['adapterOther'] ?? '';

    // 初始化TCPDF对象
    $pdf = new TCPDF();
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('生产指令单系统');
    $pdf->SetTitle('生产指令单');
    $pdf->SetHeaderData('', '', '生产指令单', '');

    // 设置页面格式
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

    // 添加页面
    $pdf->AddPage();

    // 设置内容
    $adapterText = $adapter === '其他' ? $adapterOther : $adapter;
    $html = <<<EOD
<h1>生产指令单</h1>
<table border="1" cellpadding="5">
    <tr>
        <th>客户代号</th>
        <td>$customerCode</td>
    </tr>
    <tr>
        <th>指令单号</th>
        <td>$orderNumber</td>
    </tr>
    <tr>
        <th>订单数量</th>
        <td>$quantity</td>
    </tr>
    <tr>
        <th>客户型号</th>
        <td>$model</td>
    </tr>
    <tr>
        <th>颜色</th>
        <td>$color</td>
    </tr>
    <tr>
        <th>目的国</th>
        <td>$country</td>
    </tr>
    <tr>
        <th>完工时间</th>
        <td>$completionDate</td>
    </tr>
    <tr>
        <th>试缝要求</th>
        <td>$sewingRequirements</td>
    </tr>
    <tr>
        <th>其他注意事项</th>
        <td>$notes</td>
    </tr>
    <tr>
        <th>适配器</th>
        <td colspan="3">$adapterText</td>
    </tr>
</table>
EOD;

    // 输出内容到PDF
    $pdf->writeHTML($html, true, false, true, false, '');

    // 处理上传的图片并添加到PDF中
    for ($i = 1; $i <= 16; i++) {
        $upload_field = 'upload' . $i;
        if (isset($_FILES[$upload_field])) {
            $tmp_name = $_FILES[$upload_field]['tmp_name'];
            if ($tmp_name) {
                $name = basename($_FILES[$upload_field]['name']);
                $upload_file = "uploads/$name";
                if (move_uploaded_file($tmp_name, $upload_file)) {
                    $pdf->AddPage();
                    $pdf->Image($upload_file, 15, 40, 180, 160, '', '', '', true, 150, '', false, false, 1, false, false, false);
                }
            }
        }
    }

    // 输出PDF到浏览器
    $pdf->Output('生产指令单.pdf', 'D');
}
?>
