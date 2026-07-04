<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>KostReview - Autentikasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body {
            background-color: #F3F4F6; /* Warna abu muda dari referensi */
            font-family: 'Poppins', sans-serif; /* Mengikuti tipografi referensi */
        }
        
        /* Mengubah komponen 'Primary' Bootstrap menjadi Pink Relife */
        .bg-primary {
            background-color: #EC4899 !important;
        }
        .btn-primary {
            background-color: #EC4899;
            border-color: #EC4899;
            color: #FFFFFF;
        }
        .btn-primary:hover {
            background-color: #d63d86; /* Pink sedikit gelap untuk efek hover */
            border-color: #d63d86;
            color: #FFFFFF;
        }

        /* Mengubah komponen 'Success' Bootstrap menjadi Navy Relife */
        .bg-success {
            background-color: #1E3A8A !important;
        }
        .btn-success {
            background-color: #1E3A8A;
            border-color: #1E3A8A;
            color: #FFFFFF;
        }
        .btn-success:hover {
            background-color: #162963; /* Navy sedikit gelap untuk efek hover */
            border-color: #162963;
            color: #FFFFFF;
        }
        
        /* Mempercantik Card Login/Register */
        .card {
            border-radius: 12px;
            overflow: hidden;
        }
    </style>
</head>
<body>
    
    <div class="container">
        {{ $slot }}
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>