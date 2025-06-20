<?php

require_once 'config.php';
require_once 'functions.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pawtify - Manajemen Hewan Peliharaan</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <header class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">
                    <i class="fas fa-paw mr-2 text-indigo-600"></i>Pawtify
                </h1>
                <p class="text-gray-600">Manajemen data hewan peliharaan</p>
            </div>
            <a href="add.php" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg flex items-center">
                <i class="fas fa-plus mr-2"></i> Tambah Hewan
            </a>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php
            $pets = getPets($conn);
            if (empty($pets)): ?>
                <div class="text-center py-10 text-gray-500 col-span-full">
                    <i class="fas fa-paw text-4xl mb-3"></i>
                    <p>Belum ada data hewan peliharaan</p>
                </div>
            <?php else: 
                foreach ($pets as $pet): ?>
                    <div class="bg-white rounded-lg p-6 border border-gray-200 shadow-sm">
                        <div class="flex justify-between items-start mb-3">
                            <div class="flex items-center">
                                <i class="fas <?= getPetIcon($pet['type']) ?> text-2xl mr-3 text-indigo-600"></i>
                                <h3 class="text-xl font-semibold text-gray-800"><?= htmlspecialchars($pet['name']) ?></h3>
                            </div>
                            <span class="px-2 py-1 text-xs rounded-full <?= getTypeColorClass($pet['type']) ?>">
                                <?= htmlspecialchars($pet['type']) ?>
                            </span>
                        </div>
                        
                        <div class="space-y-2 text-sm text-gray-600">
                            <div class="flex justify-between">
                                <span>Umur:</span>
                                <span class="font-medium"><?= $pet['age'] ?> tahun</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Pemilik:</span>
                                <span class="font-medium"><?= htmlspecialchars($pet['owner']) ?></span>
                            </div>
                        </div>
                        
                        <?php if (!empty($pet['health_notes'])): ?>
                        <div class="mt-4 pt-4 border-t border-gray-200">
                            <h4 class="text-sm font-medium text-gray-700 mb-2">Catatan Kesehatan</h4>
                            <p class="health-note text-sm text-gray-600 pl-5">
                                <?= htmlspecialchars($pet['health_notes']) ?>
                            </p>
                        </div>
                        <?php endif; ?>
                        
                        <div class="mt-6 flex justify-end space-x-2">
                            <a href="edit.php?id=<?= $pet['id'] ?>" class="px-3 py-1 text-sm bg-yellow-100 text-yellow-800 rounded hover:bg-yellow-200">
                                <i class="fas fa-edit mr-1"></i> Edit
                            </a>
                            <a href="delete.php?id=<?= $pet['id'] ?>" class="px-3 py-1 text-sm bg-red-100 text-red-800 rounded hover:bg-red-200" 
                               onclick="return confirm('Apakah Anda yakin ingin menghapus data hewan ini?')">
                                <i class="fas fa-trash-alt mr-1"></i> Hapus
                            </a>
                        </div>
                    </div>
                <?php endforeach;
            endif; ?>
        </div>
    </div>
</body>
</html>
