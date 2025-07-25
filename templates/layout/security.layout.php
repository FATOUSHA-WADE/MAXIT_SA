<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MAXIT SA - Mon Espace Client</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background: linear-gradient(135deg, #ffffff 0%, #ffffff 100%);
            min-height: 100vh;
        }
        .container-shadow {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        .phone-icon {
            width: 20px;
            height: 20px;
            fill: #9ca3af;
        }
        .orange-gradient {
            background: linear-gradient(135deg, #ea580c 0%, #fb923c 100%);
        }
        .input-focus:focus {
            outline: none;
            border-color: #ea580c;
            box-shadow: 0 0 0 3px rgba(234, 88, 12, 0.1);
        }
         
        .upload-area {
            border: 2px dashed #fb923c;
            border-radius: 8px;
            background-color: #fff7ed;
            transition: all 0.3s ease;
            cursor: pointer;
            min-height: 120px;
        }
        .upload-area:hover {
            border-color: #ea580c;
            background-color: #ffedd5;
        }
        .black-button {
            background: linear-gradient(135deg, #1f2937 0%, #111827 100%);
        }
        .black-button:hover {
            background: linear-gradient(135deg, #374151 0%, #1f2937 100%);
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen p-4">

    <div class="w-full max-w-4xl">
        <?php echo $content; ?>
    </div>

</body>
</html>