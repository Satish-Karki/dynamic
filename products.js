document.getElementById('add').addEventListener('submit', function (e) {
    
    const name = document.getElementById('name').value.trim();
    const description = document.getElementById('description').value.trim();
    const quantity = document.getElementById('quantity').value.trim();
    const price = document.getElementById('price').value.trim();
    const capacity = document.getElementById('capacity').value.trim();
    

    // Image inputs
    const image1 = document.querySelector('input[name="image1"]').files[0];
    const image2 = document.querySelector('input[name="image2"]').files[0];
    const image3 = document.querySelector('input[name="image3"]').files[0];
    const image4 = document.querySelector('input[name="image4"]').files[0];

    let errors = [];
    let isAnyFieldFilled = false;
    if (name === '') {
        errors.push('Name is required.');
    }
    else {
        isAnyFieldFilled = true;
    }

    if (description === '') {
        errors.push('description is required.');
    }
    else {
        isAnyFieldFilled = true;
    }

    // Validate quantity
    if (quantity === '') {
        errors.push('Quantity is required.');
    } else if (!/^\d+$/.test(quantity) || parseInt(quantity) <= 0) {
        errors.push('Quantity must be a positive whole number.');
    }
    else {
        isAnyFieldFilled = true;
    }


    // Validate price
    if (price === '') {
        errors.push('Price is required.');
    } else if (!/^\d+(\.\d+)?$/.test(price) || parseFloat(price) <= 0) {
        errors.push('Price must be a positive number.');
    }
    else {
        isAnyFieldFilled = true;
    }

    // Validate capacity
    if (capacity === '') {
        errors.push('Capacity is required.');
    } else if (!/^\d+$/.test(capacity) || parseInt(capacity) <= 0) {
        errors.push('Capacity must be a positive number.');
    }
    else {
        isAnyFieldFilled = true;
    }


    // Validate images
    if (!image1 || !image2 || !image3 || !image4) errors.push('Atleast 4 images are required.');
   
    if (!isAnyFieldFilled) {
        alert('Please add details.');
        e.preventDefault();
        return;
    }

    if (errors.length > 0) {
        alert(errors.join('\n')); 
        e.preventDefault(); // Prevent the form from submitting by default// Show errors as an alert
    } else {
        this.submit(); // Submit the form if no errors
    }
});
function previewImage(input, index) {
    const file = input.files[0]; // Get the uploaded file
    if (file) {
        const reader = new FileReader(); // Create a FileReader to read the file

        reader.onload = function (e) {
            // Set the src of the corresponding preview img
            const preview = document.getElementById(`preview-${index}`);
            preview.src = e.target.result; // Set the preview image to the uploaded file
        };

        reader.readAsDataURL(file); // Read the file as a data URL
    }
}
