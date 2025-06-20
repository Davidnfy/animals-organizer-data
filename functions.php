<?php
function getPets($conn) {
    $sql = "SELECT * FROM pets ORDER BY name ASC";
    $result = $conn->query($sql);
    
    $pets = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $pets[] = $row;
        }
    }
    return $pets;
}

function getPetIcon($type) {
    $icons = [
        'Anjing' => 'fa-dog',
        'Kucing' => 'fa-cat',
        'Burung' => 'fa-dove',
        'Kelinci' => 'fa-bunny',
        'Hamster' => 'fa-hamster',
        'Ikan' => 'fa-fish',
        'Reptil' => 'fa-snake'
    ];
    return $icons[$type] ?? 'fa-paw';
}

function getTypeColorClass($type) {
    $colors = [
        'Anjing' => 'bg-blue-100 text-blue-800',
        'Kucing' => 'bg-purple-100 text-purple-800',
        'Burung' => 'bg-green-100 text-green-800',
        'Kelinci' => 'bg-pink-100 text-pink-800',
        'Hamster' => 'bg-yellow-100 text-yellow-800',
        'Ikan' => 'bg-indigo-100 text-indigo-800',
        'Reptil' => 'bg-emerald-100 text-emerald-800'
    ];
    return $colors[$type] ?? 'bg-gray-100 text-gray-800';
}
?>
