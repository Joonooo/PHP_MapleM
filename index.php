<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>메이플스토리M - 유저 정보 조회</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .fade-in {
            animation: fadeIn 0.5s;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        body {
            display: flex;
            flex-direction: column;
            justify-content: center;
            height: 100vh;
            background: linear-gradient(to right, #6a11cb, #2575fc);
            color: #ffffff;
        }

        .btn-primary {
            transition: transform 0.4s ease, box-shadow 0.4s ease;
        }

        .btn-primary:hover,
        .btn-primary:focus {
            transform: scale(1.04);
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.3);
        }

        .result-container {
            display: none;
            margin-top: 20px;
        }

        .result-card {
            background-color: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 5px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .item-group {
            margin-bottom: 20px;
        }

        .item-name {
            font-weight: bold;
            color: #495057;
        }

        .item-detail {
            margin-left: 20px;
            color: #6c757d;
        }

        .card-title {
            color: #007bff;
            margin-bottom: 15px;
        }

        .card-body>div {
            margin-bottom: 10px;
            line-height: 1.5;
        }

        .card-body>div:last-child {
            margin-bottom: 0;
        }

        .card-body strong {
            color: #495057;
        }

        @media (max-width: 768px) {
            .btn {
                padding: 0.75rem 1.25rem;
                font-size: 1rem
            }
        }
    </style>
</head>

<body>
    <div class="container mt-5 text-center">
        <h2 class="mb-4">메이플스토리M - 유저 정보 조회</h2>
        <div class="d-grid gap-2 col-6 mx-auto">
            <a href="basic.php" class="btn btn-primary mt-3">캐릭터 정보 조회</a>
            <a href="guild.php" class="btn btn-primary mt-3">가입한 길드 이름 조회</a>
            <a href="item.php" class="btn btn-primary mt-3">장착 아이템 정보 조회</a>
            <a href="stat.php" class="btn btn-primary mt-3">캐릭터 스탯 정보 조회</a>
        </div>
    </div>
</body>

</html>