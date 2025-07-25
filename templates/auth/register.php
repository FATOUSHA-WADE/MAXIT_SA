<?php
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
    <!-- Header -->
    <div class="text-center mb-12">
        <h1 class="text-3xl font-bold text-gray-800">
            <span class="text-orange-600">MAXIT</span> SA
        </h1>
    </div>

    <!-- Formulaire -->
    <form class="space-y-6" action="/register" method="POST" enctype="multipart/form-data">
        <!-- Ligne 1: NOM et PRENOM -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-orange-600 font-semibold mb-2">
                    NOM <span class="text-orange-600">*</span>
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <input 
                        type="text" 
                        class="w-full pl-10 pr-4 py-3 border-2 border-orange-300 rounded-lg text-gray-700 input-focus transition-all duration-200"
                        name="nom"
                        value="<?= htmlspecialchars($old['nom'] ?? '') ?>"
                    >
                </div>
                <?php if (!empty($errors['nom'])): ?>
                    <?php foreach ($errors['nom'] as $error): ?>
                        <div class="text-red-600 text-xs mt-1"><?= htmlspecialchars($error) ?></div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <div>
                <label class="block text-orange-600 font-semibold mb-2">
                    PRENOM <span class="text-orange-600">*</span>
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <input 
                        type="text" 
                        class="w-full pl-10 pr-4 py-3 border-2 border-orange-300 rounded-lg text-gray-700 input-focus transition-all duration-200"
                        name="prenom"
                        value="<?= htmlspecialchars($old['prenom'] ?? '') ?>"
                    >
                </div>
                <?php if (!empty($errors['prenom'])): ?>
                    <?php foreach ($errors['prenom'] as $error): ?>
                        <div class="text-red-600 text-xs mt-1"><?= htmlspecialchars($error) ?></div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <!-- CIN -->
        <div>
            <label class="block text-orange-600 font-semibold mb-2">
                CIN <span class="text-orange-600">*</span>
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2H4zm0 2h12v8H4V6z" clip-rule="evenodd"></path>
                </div>
                <input 
                    type="text" 
                    class="w-full pl-10 pr-4 py-3 border-2 border-orange-300 rounded-lg text-gray-700 input-focus transition-all duration-200"
                    name="numero_cni"
                    value="<?= htmlspecialchars($old['numero_cni'] ?? '') ?>"
                >

            </div>
            <?php if (!empty($errors['numero_cni'])): ?>
                <?php foreach ($errors['numero_cni'] as $error): ?>
                    <div class="text-red-600 text-xs mt-1"><?= htmlspecialchars($error) ?></div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- Numero Telephone -->
        <div>
            <label class="block text-orange-600 font-semibold mb-2">
                Numero Telephone <span class="text-orange-600">*</span>
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"></path>
                    </svg>
                </div>
                <input 
                    type="tel" 
                    class="w-full pl-10 pr-4 py-3 border-2 border-orange-300 rounded-lg text-gray-700 input-focus transition-all duration-200"
                    name="numero_telephone"
                    value="<?= htmlspecialchars($old['numero_telephone'] ?? '') ?>"
                >
            </div>
            <?php if (!empty($errors['numero_telephone'])): ?>
                <?php foreach ($errors['numero_telephone'] as $error): ?>
                    <div class="text-red-600 text-xs mt-1"><?= htmlspecialchars($error) ?></div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- Ajouter après le champ téléphone -->
        <div>
            <label class="block text-orange-600 font-semibold mb-2">
                Mot de passe <span class="text-orange-600">*</span>
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <input 
                    type="password" 
                    class="w-full pl-10 pr-4 py-3 border-2 border-orange-300 rounded-lg text-gray-700 input-focus transition-all duration-200"
                    name="password"
                    placeholder="Entrez votre mot de passe"
                    
                >
            </div>
            <?php if (!empty($errors['password'])): ?>
                <?php foreach ($errors['password'] as $error): ?>
                    <div class="text-red-600 text-xs mt-1"><?= htmlspecialchars($error) ?></div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- Ligne 2: RECTO CIN et VERSO CIN -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-orange-600 font-semibold mb-2">
                    RECTO CIN <span class="text-orange-600">*</span>
                </label>
                <div class="upload-area flex flex-col items-center justify-center p-6" onclick="document.getElementById('recto').click()">
                    <svg class="w-8 h-8 text-gray-800 mb-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-orange-600 font-medium">Clip To Update</span>
                    <input type="file" id="recto" class="hidden" accept="image/*" name="photorecto" value="<?= htmlspecialchars($old['photorecto'] ?? '') ?>">
                  
                </div>
                  <?php if (!empty($errors['photorecto'])): ?>
                <?php foreach ($errors['photorecto'] as $error): ?>
                    <div class="text-red-600 text-xs mt-1"><?= htmlspecialchars($error) ?></div>
                <?php endforeach; ?>
            <?php endif; ?>
            </div>
            <div>
                <label class="block text-orange-600 font-semibold mb-2">
                    VERSO CIN <span class="text-orange-600">*</span>
                </label>
                <div class="upload-area flex flex-col items-center justify-center p-6" onclick="document.getElementById('verso').click()">
                    <svg class="w-8 h-8 text-gray-800 mb-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-orange-600 font-medium">Clip To Update</span>
                    <input type="file" id="verso" class="hidden" accept="image/*" name="photoverso" value="<?= htmlspecialchars($old['photoverso'] ?? '') ?>">
                    
                </div>
                <?php if (!empty($errors['photoverso'])): ?>
                <?php foreach ($errors['photoverso'] as $error): ?>
                    <div class="text-red-600 text-xs mt-1"><?= htmlspecialchars($error) ?></div>
                <?php endforeach; ?>
            <?php endif; ?>
            </div>
        </div>

        <!-- Bouton créer mon compte -->
        <div class="flex justify-center pt-6">
            <button class="px-12 py-4 black-button text-orange-600 font-semibold rounded-lg hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200">
                créer mon Compte
            </button>
        </div>
    </form>

    <!-- Affichage des messages d'erreur globaux -->
    <?php if (!empty($errors['global'])): ?>
        <div class="mb-6">
            <?php foreach ($errors['global'] as $error): ?>
                <div class="text-red-600 text-sm mb-1"><?= htmlspecialchars($error) ?></div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>