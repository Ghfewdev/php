<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $targetDir = "images/";

    if(isset($_FILES["img1"]) && $_FILES["img1"]["error"] === 0){
        move_uploaded_file($_FILES["img1"]["tmp_name"], $targetDir . "das112.jpg");
    }

    if(isset($_FILES["img2"]) && $_FILES["img2"]["error"] === 0){
        move_uploaded_file($_FILES["img2"]["tmp_name"], $targetDir . "das212.jpg");
    }

    header("Location: ".$_SERVER['PHP_SELF']);
    exit();
}

?>
<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8" />
<title>Telemedicine</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-white text-gray-800 relative">


<!-- ปุ่ม unhide มุมขวาบน -->
<button
onclick="toggleUpload()"
class="absolute bottom-2 right-2 text-gray-300 hover:text-gray-700 text-sm"
>
⚙
</button>


<!-- upload panel -->
<form id="uploadPanel"
method="post"
enctype="multipart/form-data"
class="hidden absolute bottom-10 right-2 bg-white border p-3 rounded shadow text-xs">

<label for="img1" class="custom-file-upload">
    <i class="fa fa-cloud-upload"></i> เลือกรูปภาพ ที่ 1
</label>
<input id="img1" type="file" name="img1" accept="image/*" class="block mb-2">

<label for="img2" class="custom-file-upload">
    <i class="fa fa-cloud-upload"></i> เลือกรูปภาพ ที่ 2
</label>
<input id="img2" type="file" name="img2" accept="image/*" class="block mb-2">

<button class="bg-gray-500 text-white px-3 py-1 rounded">
อัพเดท
</button>

</form>


<div class="grid justify-center text-center min-h-screen">

<br>
<p class="text-5xl">Telemedicine</p>
<br><br>

<img
src="images/das112.jpg?v=<?php echo time(); ?>"
width="1200"
class="border-2 border-black mx-auto"
/>

<br><br>

<img
src="images/das212.jpg?v=<?php echo time(); ?>"
width="1200"
class="border-2 border-black mx-auto"
/>

</div>


<script>

function toggleUpload(){
    const panel = document.getElementById("uploadPanel");
    panel.classList.toggle("hidden");
}

</script>

</body>
</html>