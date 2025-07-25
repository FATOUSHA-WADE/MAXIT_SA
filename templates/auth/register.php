<?php
$cni = $_GET['cni'] ?? null;
$afficher_formulaire = !empty($cni);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <script>
        async function verifierCNI(event) {
            event.preventDefault();
            const cni = document.getElementById("cni").value.trim();

            if (!cni) {
                alert("Veuillez entrer un numéro CNI.");
                return;
            }

            try {
                const response = await fetch(`https://appdaf-0soa.onrender.com/citoyens/${cni}`);

                if (response.ok) {
                    const data = await response.json();
                    if (Object.keys(data).length > 0) {
                        // Rediriger avec le cni comme paramètre
                        window.location.href = "registre.php?cni=" + encodeURIComponent(cni);
                    } else {
                        alert("Aucun citoyen trouvé avec ce CNI.");
                    }
                } else {
                    alert("CNI non trouvé.");
                }
            } catch (error) {
                console.error("Erreur de requête :", error);
                alert("Erreur réseau.");
            }
        }
    </script>
</head>
<body>

<?php if (!$afficher_formulaire): ?>
    <!-- Étape 1 : Vérification du CNI -->
    <div style="max-width: 400px; margin: auto; padding: 40px; background: #fff; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
        <h2 style="text-align:center; color: #EA580C;">Vérification CNI</h2>
        <form onsubmit="verifierCNI(event)">
            <label for="cni">Numéro CNI :</label>
            <input type="text" id="cni" name="cni" style="width: 100%; padding: 10px; margin-top: 10px; border: 1px solid #EA580C; border-radius: 5px;">
            <button type="submit" style="margin-top: 20px; background-color: #EA580C; color: white; border: none; padding: 10px 20px; border-radius: 5px;">Vérifier</button>
        </form>
    </div>

<?php else: ?>
    <!-- Étape 2 : Affichage du formulaire d'inscription -->
    <!-- ICI ton formulaire existant, modifié pour préremplir le champ CIN -->

    <?php
        // Simuler ce que tu récupères depuis ton framework
        $old = [];
        $errors = $this->session->unset('errors') ?? [];
        $success = $this->session->unset('success') ?? '';
    ?>

    <div class="w-full max-w-md">
        <?php if ($success): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                <strong class="font-bold">Succès!</strong>
                <span class="block sm:inline"><?= htmlspecialchars($success) ?></span>
            </div>
        <?php endif; ?>
    </div>

    <div class="bg-white rounded-lg container-shadow p-8 mx-auto">
        <div class="text-center mb-12">
            <h1 class="text-3xl font-bold text-gray-800">
                <span class="text-orange-600">MAXIT</span> SA
            </h1>
        </div>

        <!-- FORMULAIRE -->
        <form class="space-y-6" action="/register" method="POST" enctype="multipart/form-data">
            <!-- NOM, PRENOM -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-orange-600 font-semibold mb-2">NOM <span class="text-orange-600">*</span></label>
                    <input type="text" name="nom" class="w-full px-4 py-3 border-2 border-orange-300 rounded-lg" value="<?= htmlspecialchars($old['nom'] ?? '') ?>">
                </div>
                <div>
                    <label class="block text-orange-600 font-semibold mb-2">PRENOM <span class="text-orange-600">*</span></label>
                    <input type="text" name="prenom" class="w-full px-4 py-3 border-2 border-orange-300 rounded-lg" value="<?= htmlspecialchars($old['prenom'] ?? '') ?>">
                </div>
            </div>

            <!-- CNI -->
            <div>
                <label class="block text-orange-600 font-semibold mb-2">CIN <span class="text-orange-600">*</span></label>
                <input 
                    type="text" 
                    name="numero_cni" 
                    class="w-full px-4 py-3 border-2 border-orange-300 rounded-lg"
                    value="<?= htmlspecialchars($cni ?? ($old['numero_cni'] ?? '')) ?>"
                    readonly
                >
            </div>

            <!-- Ajoute ici les autres champs comme téléphone, mot de passe, etc. -->

            <div class="flex justify-center pt-6">
                <button class="px-12 py-4 black-button text-orange-600 font-semibold rounded-lg hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200">
                    Créer mon Compte
                </button>
            </div>
        </form>
    </div>

<?php endif; ?>

</body>
</html>
