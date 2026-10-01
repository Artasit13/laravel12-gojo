<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Me</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="card shadow-sm mx-auto" style="max-width: 600px;">
            <div class="card-body text-center p-4">
                <h3 class="mb-3">ข้อมูลส่วนตัว</h3>
                
                <!-- ส่วนแสดงรูปภาพ (เปลี่ยน URL ใน src เป็นลิงก์รูปของคุณ หรือรูปในโฟลเดอร์ public) -->
                <img src="https://ui-avatars.com/api/?name=Atthasit+Iamsaad&size=150&background=0D8ABC&color=fff" 
                     alt="Profile Picture" 
                     class="rounded-circle mb-3 shadow-sm" 
                     width="150" height="150" style="object-fit: cover;">

                <p class="fs-5 mb-1"><strong>ชื่อ-นามสกุล:</strong> นายอรรถสิทธิ์ เอี่ยมสอาด</p>
                <p class="fs-5 text-muted"><strong>รหัสนักศึกษา:</strong> 68122420013</p>
                
                <hr class="my-4">
                
                <h5 class="mb-3">ลิงก์ผลงาน</h5>
                <div class="d-grid gap-2">
                    <a href="{{ url('/gallery') }}" class="btn btn-primary">EP02 Hero (/gallery)</a>
                    <a href="{{ url('/active/index') }}" class="btn btn-primary">EP03 Active Bootstrap (/active/index)</a>
                    <a href="{{ url('/weights') }}" class="btn btn-primary">EP07 Weight (/weights)</a>
                    <a href="{{ url('/login') }}" class="btn btn-success">EP08 Auth Login (/login)</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>