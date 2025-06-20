<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $type = $_POST['type'];
    $age = $_POST['age'];
    $owner = $_POST['owner'];
    $health_notes = $_POST['health_notes'] ?? null;
    
    $stmt = $conn->prepare("INSERT INTO pets (name, type, age, owner, health_notes) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdss", $name, $type, $age, $owner, $health_notes);
    
    if ($stmt->execute()) {
        header("Location: index.php?success=1");
        exit();
    } else {
        $error = "Gagal menambahkan data: " . $stmt->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Hewan - PetCare</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-md mx-auto bg-white rounded-lg shadow-md p-6">
            <h2 class="text-2xl font-semibold text-gray-800 mb-6">
                <i class="fas fa-plus-circle mr-2 text-indigo-600"></i>Tambah Hewan Baru
            </h2>
            
            <?php if (isset($error)): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <?= $error ?>
                </div>
            <?php endif; ?>
            
            <form action="add.php" method="POST" class="space-y-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Hewan</label>
                    <input type="text" id="name" name="name" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                
                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Jenis Hewan</label>
                    <select id="type" name="type" required 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="">Pilih Jenis</option>
                        <option value="Anjing">Anjing</option>
                        <option value="Kucing">Kucing</option>
                        <option value="Burung">Burung</option>
                        <option value="Kelinci">Kelinci</option>
                        <option value="Hamster">Hamster</option>
                        <option value="Ikan">Ikan</option>
                        <option value="Reptil">Reptil</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>
                
                <div>
                    <label for="age" class="block text-sm font-medium text-gray-700 mb-1">Umur (tahun)</label>
                    <input type="number" id="age" name="age" min="0" max="50" step="0.1" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                
                <div>
                    <label for="owner" class="block text-sm font-medium text-gray-700 mb-1">Nama Pemilik</label>
                    <input type="text" id="owner" name="owner" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                
                <div>
                    <label for="health_notes" class="block text-sm font-medium text-gray-700 mb-1">Catatan Kesehatan</label>
                    <textarea id="health_notes" name="health_notes" rows="3" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"></textarea>
                </div>
                
                <div class="flex justify-end space-x-3 pt-2">
                    <a href="index.php" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-100">
                        Batal
                    </a>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
