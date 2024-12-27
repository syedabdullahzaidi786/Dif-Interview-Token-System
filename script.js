// Initialize the token number counter
let currentToken = 1;

// Function to generate a unique token number
document.getElementById("generate-token").addEventListener("click", function() {
    const name = document.getElementById("name").value.trim();
    const bform = document.getElementById("bform").value.trim();

    if (name === "" || bform === "") {
        alert("Please enter both your name and B-form number.");
        return;
    }

    // Generate a token number
    const tokenNumber = generateToken();
    
    if (tokenNumber) {
        // Display the generated token number
        document.getElementById("token-display").innerText = `Your Token Number: ${tokenNumber}`;
        
        // Show token slip buttons (Download and Print)
        document.getElementById("token-slip-buttons").style.display = "block";
        
        // Update the preview slip
        updatePreview(tokenNumber, name, bform);

        // Store token details
        window.tokenDetails = {
            tokenNumber: tokenNumber,
            name: name,
            bform: bform,
            date: new Date().toLocaleDateString(),
            time: new Date().toLocaleTimeString()
        };
    } else {
        // In case all tokens have been assigned
       // In case all tokens have been assigned
document.getElementById("token-display").innerHTML = '<span style="color: red;">Sorry, All Token Numbers have been Assigned.</span>';

    }
});

// Function to generate the next token number in line
function generateToken() {
    if (currentToken > 70) {
        return null;  // Return null if all tokens from 1 to 70 have been assigned
    }

    // Return the current token number and increment it for the next time
    return currentToken++;
}

// Update the preview slip with generated details
function updatePreview(tokenNumber, name, bform) {
    document.getElementById("preview-token-number").innerText = tokenNumber;
    document.getElementById("preview-name").innerText = name;
    document.getElementById("preview-bform").innerText = bform;
    document.getElementById("preview-date").innerText = new Date().toLocaleDateString();
    document.getElementById("preview-time").innerText = new Date().toLocaleTimeString();
    document.getElementById("token-slip-preview").style.display = "block";
}

// Generate and Download Token Slip as PDF
document.getElementById("download-slip").addEventListener("click", function() {
    const { tokenNumber, name, bform, date, time } = window.tokenDetails;

    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();

    // Add content to the PDF (Token Slip Style)
    doc.setFontSize(16);
    doc.text("Token Slip", 20, 20);
    doc.setFontSize(12);
    doc.text(`Token Number: ${tokenNumber}`, 20, 40);
    doc.text(`Name: ${name}`, 20, 50);
    doc.text(`B-Form Number: ${bform}`, 20, 60);
    doc.text(`Date: ${date}`, 20, 70);
    doc.text(`Time: ${time}`, 20, 80);

    // Download the PDF
    doc.save("token-slip.pdf");
});

// Print the Token Slip
document.getElementById("print-slip").addEventListener("click", function() {
    const { tokenNumber, name, bform, date, time } = window.tokenDetails;

    const printWindow = window.open('', '_blank');
    printWindow.document.write(`
        <html>
            <head>
                <title>Token Slip</title>
                <style>
                    body { font-family: 'Arial', sans-serif; }
                    .print-slip-content {
                        width: 200px;
                        padding: 10px;
                        margin: 0 auto;
                        border: 1px solid #ddd;
                        text-align: center;
                        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
                    }
                    .print-slip-content img {
                        width: 80px;
                        margin-bottom: 10px;
                    }
                    .print-slip-content h3 {
                        font-size: 16px;
                        color: #2d6a4f;
                    }
                    .print-slip-content p {
                        font-size: 12px;
                        color: #333;
                        margin-bottom: 5px;
                    }
                    @media print {
                        body {
                            margin: 0;
                            padding: 0;
                        }
                        .print-slip-content {
                            width: 200px;
                            padding: 15px;
                            border: 2px dashed #2d6a4f;
                        }
                        .print-slip-content img {
                            width: 70px;
                            margin-bottom: 5px;
                        }
                        .print-slip-content h3 {
                            font-size: 18px;
                        }
                        .print-slip-content p {
                            font-size: 12px;
                        }
                    }
                </style>
            </head>
            <body>
                <div class="print-slip-content">
                    <img src="logo.png" alt="Logo">
                    <h3>Token Slip</h3>
                    <p><strong>Token Number:</strong> ${tokenNumber}</p>
                    <p><strong>Name:</strong> ${name}</p>
                    <p><strong>B-Form Number:</strong> ${bform}</p>
                    <p><strong>Date:</strong> ${date}</p>
                    <p><strong>Time:</strong> ${time}</p>
                </div>
            </body>
        </html>
    `);
    printWindow.document.close();
    printWindow.print();
});
