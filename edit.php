<?php
require_once 'config.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $type = $_POST['type'];
    $age = $_POST['age'];
    $owner = $_POST['owner'];
    $health_notes = $_POST['health_notes'] ?? null;
    
    $stmt = $conn->prepare("UPDATE pets SET name=?, type=?, age=?, owner=?, health_notes=? WHERE id=?");
    $stmt->bind_param("ssdssi", $name, $type, $age, $owner, $health_notes, $id);
    
    if ($stmt->execute()) {
        header("Location: index.php?success=1");
        exit();
    } else {
        $error = "Gagal mengupdate data: " . $stmt->error;
    }
}

// Ambil data hewan yang akan diedit
$stmt = $conn->prepare("SELECT * FROM pets WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$pet = $result->fetch_assoc();

if (!$pet) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Hewan - PetCare</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-md mx-auto bg-white rounded-lg shadow-md p-6">
            <h2 class="text-2xl font-semibold text-gray-800 mb-6">
                <i class="fas fa-edit mr-2 text-indigo-600"></i>Edit Data Hewan
            </h2>
            
            <?php if (isset($error)): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <?= $error ?>
                </div>
            <?php endif; ?>
            
            <form action="edit.php?id=<?= $id ?>" method="POST" class="space-y-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Hewan</label>
                    <input type="text" id="name" name="name" value="<?= htmlspecialchars($pet['name']) ?>" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                
                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Jenis Hewan</label>
                    <select id="type" name="type" required 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="">Pilih Jenis</option>
                        <option value="Anjing" <?= $pet['type'] === 'Anjing' ? 'selected' : '' ?>>Anjing</option>
                        <option value="Kucing" <?= $pet['type'] === 'Kucing' ? 'selected' : '' ?>>Kucing</option>
                        <option value="Burung" <?= $pet['type'] === 'Burung' ? 'selected' : '' ?>>Burung</option>
                        <option value="Kelinci" <?= $pet['type'] === 'Kelinci' ? 'selected' : '' ?>>Kelinci</option>
                        <option value="Hamster" <?= $pet['type'] === 'Hamster' ? 'selected' : '' ?>>Hamster</option>
                        <option value="Ikan" <?= $pet['type'] === 'Ikan' ? 'selected' : '' ?>>Ikan</option>
                        <option value="Reptil" <?= $pet['type'] === 'Reptil' ? 'selected' : '' ?>>Reptil</option>
                        <option value="Lainnya" <?= $pet['type'] === 'Lainnya' ? 'selected' : '' ?>>Lainnya</option>
                    </select>
                </div>
                
                <div>
                    <label for="age" class="block text-sm font-medium text-gray-700 mb-1">Umur (tahun)</label>
                    <input type="number" id="age" name="age" min="0" max="50" step="0.1" value="<?= $pet['age'] ?>" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                
                <div>
                    <label for="owner" class="block text-sm font-medium text-gray-700 mb-1">Nama Pemilik</label>
                    <input type="text" id="owner" name="owner" value="<?= htmlspecialchars($pet['owner']) ?>" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                
                <div>
                    <label for="health_notes" class="block text-sm font-medium text-gray-700 mb-1">Catatan Kesehatan</label>
                    <textarea id="health_notes" name="health_notes" rows="3" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"><?= htmlspecialchars($pet['health_notes'] ?? '') ?></textarea>
                </div>
                
                <div class="flex justify-end space-x-3 pt-2">
                    <a href="index.php" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-100">
                        Batal
                    </a>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
