// Data structure to store breeds for each pet type
const breeds = {
    Dog: ["Pitbull", "Telomian", "Shih Tzu", "Indian spitz", "Pomeranian", "German Shephard"],
    Cat: ["Tabby", "Persian cat", "Arabian Mau"]
};

// Function to update breed options based on selected pet type
function updateBreedOptions() {
    var petType = document.getElementById('pet-type').value;
    var breedSelect = document.getElementById('breed');

    // Clear current breed options
    breedSelect.innerHTML = '<option value="">All</option>';

    if (petType) {
        // Add breeds corresponding to the selected pet type
        breeds[petType].forEach(function(breed) {
            var option = document.createElement('option');
            option.value = breed;
            option.textContent = breed;
            breedSelect.appendChild(option);
        });
    }
}

// Function to filter pets based on selected criteria
function filterPets() {
    var petType = document.getElementById('pet-type').value;
    var gender = document.getElementById('gender').value;
    var breed = document.getElementById('breed').value;
    var age = document.getElementById('age').value;
    
    var petItems = document.querySelectorAll('.pet-item');

    petItems.forEach(function(item) {
        var itemType = item.querySelector('h4:nth-child(2)').textContent.includes(petType) || petType === '';
        var itemGender = item.querySelector('h4:nth-child(3)').textContent.includes(gender) || gender === '';
        var itemBreed = item.querySelector('h4:nth-child(4)').textContent.includes(breed) || breed === '';
        var itemAge = item.querySelector('h4:nth-child(5)').textContent.includes(age) || age === '';

        if (itemType && itemGender && itemBreed && itemAge) {
            item.style.display = 'block';
        } else {
            item.style.display = 'none';
        }
    });
}

// Function to reset all filters and show all pets
function resetFilters() {
    document.getElementById('pet-type').value = '';
    document.getElementById('gender').value = '';
    document.getElementById('breed').value = '';
    document.getElementById('age').value = '';
    
    updateBreedOptions();
    filterPets();
}

// Add event listener to update breed options when pet type changes
document.getElementById('pet-type').addEventListener('change', updateBreedOptions);

// Add event listeners to filter pets when filter values change
document.getElementById('pet-type').addEventListener('change', filterPets);
document.getElementById('gender').addEventListener('change', filterPets);
document.getElementById('breed').addEventListener('change', filterPets);
document.getElementById('age').addEventListener('change', filterPets);

// Initial population of breed options on page load
updateBreedOptions();
