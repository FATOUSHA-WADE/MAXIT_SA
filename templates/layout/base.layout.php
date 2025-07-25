<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portefeuille Mobile</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: #f5f5f5;
            height: 100vh;
            display: flex;
            overflow: hidden;
        }

        .sidebar {
            width: 280px;
            background-color: #1a1a1a;
            color: white;
            padding: 24px;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .profile {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .profile-avatar {
            width: 45px;
            height: 45px;
            background-color: #ff8c00;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .profile-info {
            flex: 1;
        }

        .profile-name {
            font-size: 16px;
            font-weight: 500;
            color: white;
            margin-bottom: 4px;
        }

        .profile-phone {
            font-size: 13px;
            color: #ccc;
        }

        .sidebar-button {
            background-color: #333;
            color: white;
            border: none;
            padding: 14px 18px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
            text-align: left;
            width: 100%;
        }

        .sidebar-button:hover {
            background-color: #444;
        }

        .sidebar-bottom {
            margin-top: auto;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .sidebar-link {
            color: #ff8c00;
            text-decoration: none;
            font-size: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 0;
        }

        .sidebar-link:hover {
            color: #ffb347;
        }

        .main-content {
            flex: 1;
            padding: 20px;
            background-color: #f5f5f5;
            overflow-y: auto;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .search-bar {
            flex: 1;
            max-width: 600px;
            position: relative;
        }

        .search-input {
            width: 100%;
            padding: 12px 16px 12px 45px;
            border: none;
            border-radius: 12px;
            background-color: #e5e5e5;
            font-size: 14px;
        }

        .search-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
        }

        .menu-button {
            width: 48px;
            height: 48px;
            background-color: #ff8c00;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        .balance-card {
            background: linear-gradient(135deg, #f0f0f0 0%, #e0e0e0 100%);
            border-radius: 16px;
            padding: 24px;
            margin-bottom: 20px;
            position: relative;
        }

        .balance-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
        }

        .balance-arrows {
            display: flex;
            gap: 8px;
        }

        .arrow {
            color: #ff8c00;
            font-size: 18px;
        }

        .balance-type {
            background-color: white;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 14px;
            color: #ff8c00;
            border: 1px solid #ff8c00;
        }

        .balance-amount {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 12px;
        }

        .currency-icon {
            width: 32px;
            height: 32px;
            background-color: #333;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        .amount {
            font-size: 32px;
            font-weight: bold;
            color: #ff8c00;
        }

        .balance-link {
            color: #ff8c00;
            text-decoration: none;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .transactions-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .transactions-title {
            font-size: 18px;
            font-weight: 500;
            color: #333;
        }

        .see-more {
            color: #ff8c00;
            text-decoration: none;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .transactions-list {
            background-color: white;
            border-radius: 12px;
            padding: 16px;
            max-height: 500px;
            overflow-y: auto;
        }

        .transaction-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .transaction-item:last-child {
            border-bottom: none;
        }

        .transaction-icon {
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            color: #666;
        }

        .transaction-details {
            flex: 1;
        }

        .transaction-title {
            font-size: 14px;
            font-weight: 500;
            color: #333;
            margin-bottom: 4px;
        }

        .transaction-date {
            font-size: 12px;
            color: #999;
        }

        .transaction-amount-container {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .transaction-amount {
            font-size: 14px;
            font-weight: 500;
            color: #333;
        }

        .transaction-badge {
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: 500;
            text-transform: uppercase;
        }

        .badge-envoi {
            background-color: #ffebee;
            color: #d32f2f;
        }

        .badge-reception {
            background-color: #e8f5e8;
            color: #2e7d32;
        }

        .badge-paiement {
            background-color: #e3f2fd;
            color: #1976d2;
        }

        .badge-retrait {
            background-color: #fff3e0;
            color: #f57c00;
        }

        /* Styles pour la pagination */
        .pagination {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
            padding: 16px;
            background-color: white;
            border-radius: 12px;
        }

        .pagination-btn {
            background-color: #ff8c00;
            color: white;
            padding: 10px 16px;
            border-radius: 8px;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            transition: background-color 0.2s;
        }

        .pagination-btn:hover {
            background-color: #e67c00;
            color: white;
        }

        .pagination-info {
            font-size: 14px;
            color: #666;
            text-align: center;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 250px;
            }
            
            .pagination {
                flex-direction: column;
                gap: 12px;
            }
            
            .pagination-info {
                order: -1;
            }
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="profile">
            <div class="profile-avatar">
                <i class="bi bi-person-fill"></i>
            </div>
            <div class="profile-info">
                <div class="profile-name">
                    <?= htmlspecialchars($user->getPrenom() . ' ' . $user->getNom()) ?>
                </div>
                <div class="profile-phone">
                    <?= htmlspecialchars($comptePrincipal->getNumeroTelephone()) ?>
                </div>
            </div>
        </div>
        <a href="/client/dashboard" class="sidebar-button sidebar-link">
            &nbsp;   
            <i class="bi bi-houses"></i>
            Home
        </a>
        
        <a href="/client/create-account" class="sidebar-button sidebar-link">
            <i class="bi bi-plus"></i>
            Nouveau Compte
        </a>
        <a href="/client/acountsList" class="sidebar-button sidebar-link">
            <i class="bi bi-list-check"></i>
            Voir mes Comptes
        </a>
        
        <div class="sidebar-bottom">
            <a href="#" class="sidebar-link">
                <i class="bi bi-gear"></i>
                Paramètres
            </a>
            <a href="/logout" class="sidebar-link">
                <i class="bi bi-box-arrow-right"></i>
                Déconnexion
            </a>
        </div>
    </div>
        
    <div class="main-content">
                <div class="header">
            <div class="search-bar">
                <i class="bi bi-search search-icon"></i>
                <input type="text" class="search-input" placeholder="">
            </div>
            <button class="menu-button">
                <i class="bi bi-list"></i>
            </button>
        </div>

        <div class="balance-card">
            <div class="balance-header">
                <div class="balance-arrows">
                    <i class="bi bi-arrow-up-right arrow"></i>
                    <i class="bi bi-arrow-down-left arrow"></i>
                </div>
                <div class="balance-type"><?= htmlspecialchars($compte->getTypeCompte()) ?></div>
            </div>
            <div class="balance-amount">
                <div class="currency-icon">
                    <i class="bi bi-lightning-charge"></i>
                </div>
                <div class="amount"> <?= htmlspecialchars($compte->getSolde()) ?> FCFA</div>
            </div>
            <a href="/client/dashboard" class="balance-link">
                Voir les transactions récentes <i class="bi bi-arrow-right"></i>
            </a>
        </div>
        <?php echo $content; ?>


</body>
</html>