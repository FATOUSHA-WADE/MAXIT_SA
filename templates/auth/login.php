<?php if (!empty($success)) : ?>
 <div class="bg-green-100 text-green-800 p-4 rounded-lg shadow mb-6">
    <?= htmlspecialchars($success) ?>
 </div>
<?php endif; ?>

<?php
 
  $generalError = $this->session->unset('general_error');
  
  $fieldErrors = $this->session->unset('field_errors') ?? [];
?>

<?php if (!empty($generalError)) : ?>
 <div class="bg-red-100 text-red-800 p-4 rounded-lg shadow mb-6">
    <div><?= htmlspecialchars($generalError) ?></div>
 </div>
<?php endif; ?>

 <div class="bg-white rounded-lg container-shadow p-8 mx-auto">
<!-- Header -->
 <div class="mb-16">
 <h1 class="text-3xl font-bold text-gray-800 mb-12">
 <span class="text-orange-600">MAXIT</span> SA
 </h1>
 <div class="flex items-center justify-center mb-16">
 <div class="flex items-center gap-3">
 <div class="w-8 h-8 bg-orange-600 rounded-full flex items-center justify-center">
 <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
 <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
 </svg>
 </div>
 <h2 class="text-2xl font-semibold text-gray-800">Mon Espace Client</h2>
 </div>
 </div>
 </div>

<!-- Formulaire -->
 <form class="flex flex-col items-center space-y-8" method="POST" action="/">
<!-- Champ de saisie téléphone -->
 <div class="w-full max-w-md">
 <div class="relative">
 <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
 <svg class="phone-icon" fill="currentColor" viewBox="0 0 20 20">
 <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"></path>
 </svg>
 </div>
 <input
type="text"
placeholder="Entrez Votre Numero de Telephone"
class="w-full pl-12 pr-4 py-4 border-2 <?= !empty($fieldErrors['telephone']) ? 'border-red-300' : 'border-orange-300' ?> rounded-full text-gray-700 placeholder-gray-500 input-focus transition-all duration-200"
    name="telephone"
    value="<?= htmlspecialchars($old['telephone'] ?? '') ?>"
 >
 </div>
 <!-- Erreurs de validation du champ téléphone -->
 <?php if (!empty($fieldErrors['telephone'])): ?>
    <?php foreach ($fieldErrors['telephone'] as $error): ?>
        <div class="text-red-600 text-xs mt-1"><?= htmlspecialchars($error) ?></div>
    <?php endforeach; ?>
 <?php endif; ?>
 </div>

<!-- Champ mot de passe -->
 <div class="w-full max-w-md">
 <div class="relative">
 <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
 <svg class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
 <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
 </svg>
 </div>
 <input
type="password"
placeholder="Entrez Votre Mot de Passe"
class="w-full pl-12 pr-4 py-4 border-2 <?= !empty($fieldErrors['password']) ? 'border-red-300' : 'border-orange-300' ?> rounded-full text-gray-700 placeholder-gray-500 input-focus transition-all duration-200"
    name="password"
 >
 </div>
 <!-- Erreurs de validation du champ password -->
 <?php if (!empty($fieldErrors['password'])): ?>
    <?php foreach ($fieldErrors['password'] as $error): ?>
        <div class="text-red-600 text-xs mt-1"><?= htmlspecialchars($error) ?></div>
    <?php endforeach; ?>
 <?php endif; ?>
 </div>

<!-- Bouton Suivant -->
 <button type="submit" class="px-12 py-4 orange-gradient text-white font-semibold rounded-full hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200">
 Suivant
 </button>

<!-- Lien créer mon compte -->
 <a href="/register" class="text-orange-600 hover:text-orange-700 transition-colors duration-200 text-sm">
 creer mon Compte
 </a>
 </div>
</form>