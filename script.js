document.getElementById("generate-token").addEventListener("click", function () {
    const name = document.getElementById("name").value.trim();
    const bform = document.getElementById("bform").value.trim();

    if (name === "" || bform === "") {
        alert("Please enter both the student name and B-Form number.");
        return;
    }

    // Send data to the PHP backend to generate a new token
    fetch('token_handler.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({
            name: name,
            bform: bform,
        }).toString(),
    })
        .then(response => response.json())
        .then(data => {
            if (data.status === "success") {
                // Display the token information
                document.getElementById("token-display").innerText = `Your Token Number: ${data.tokenNumber}`;
                document.getElementById("token-slip-preview").style.display = "block";
                document.getElementById("token-slip-buttons").style.display = "block";
                updatePreview(data.tokenNumber, data.name, data.bform);
            } else {
                alert("Error: " + data.message);
            }
        })
        .catch(error => console.error('Error:', error));
});

function updatePreview(tokenNumber, name, bform) {
    document.getElementById("preview-token-number").innerText = tokenNumber;
    document.getElementById("preview-name").innerText = name;
    document.getElementById("preview-bform").innerText = bform;
    document.getElementById("preview-date").innerText = new Date().toLocaleDateString();
    document.getElementById("preview-time").innerText = new Date().toLocaleTimeString();
}

// Download the token slip as PDF
document.getElementById("download-slip").addEventListener("click", function () {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();

    const tokenSlipContent = document.getElementById("preview-slip").innerHTML;

    doc.html(tokenSlipContent, {
        callback: function (doc) {
            doc.save("TokenSlip.pdf");
        },
    });
});

// Print the token slip
document.getElementById("print-slip").addEventListener("click", function () {
    // Assuming your token data is stored in #preview-slip (or a specific object).
    const printContent = document.getElementById("preview-slip").innerHTML; // Get the token slip content
    const originalContent = document.body.innerHTML; // Save the original content of the page

    // Create a new window for printing
    const printWindow = window.open('', '_blank', 'width=600,height=400');

    // Write the token slip content to the new window with the appropriate styles for printing
    printWindow.document.write(`
        <html>
            <head>
                <title>Token Slip</title>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        margin: 0;
                        padding: 0;
                    }
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
                            width: 250px;
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
                    
                    ${printContent} <!-- The content from the preview slip -->
                </div>
            </body>
        </html>
    `);

    // Close the document to render the content
    printWindow.document.close();
    printWindow.print(); // Trigger the print dialog

    // Restore the original content of the page
    document.body.innerHTML = originalContent;
});

