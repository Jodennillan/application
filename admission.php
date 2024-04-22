<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admission</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
        body {
            display: flex;
            font-family: Arial, sans-serif;
        }

        .sidebar {
            width: 200px;
            background-color: #343a40;
            color: white;
            padding: 15px;
            position: fixed;
            height: 100%;
            overflow-y: auto;
        }

        .sidebar a {
            display: block;
            color: white;
            text-decoration: none;
            padding: 10px;
            margin-bottom: 5px;
            transition: background 0.3s;
        }

        .sidebar a:hover {
            background-color: #495057;
        }

        .content {
            margin-left: 210px;
            padding: 20px;
            width: 100%;
            height: auto;
        }

        .card {
            margin-bottom: 20px;
        }

        .card-header {
            background-color: #007bff;
            color: white;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>Admission</h2>
        <a  onclick="showContent('admission')">Admission</a>
        <a  onclick="showContent('dates')">Important Dates</a>
        <a  onclick="showContent('fees')">Fee Payment Information</a>
        <a  onclick="showContent('documents')">Required Documents</a>
        <a  onclick="showContent('support')">Support</a>
    </div>

    <div class="content">
        <div id="admission" class="card">
            <div class="card-body">
                <h3>Welcome to Admission!</h3>
                <p>Congratulations on being accepted! Please follow the instructions below to complete your admission process.</p>
            </div>
        </div>
        <div id="dates" class="card" style="display: none;">
            <div class="card-body">
                <h4>Important Dates</h4>
                <ul>
                    <li>Orientation: [1/5/2024]</li>
                    <li>Classes Start: [7/5/2024]</li>
                    <li>Fee Payment Deadline: [28/5/2024]</li>
                    <li>Document Submission Deadline: [7/5/2024]</li>
                </ul>
            </div>
        </div>
        <div id="fees" class="card" style="display: none;">
            <div class="card-body">
                <h4>Fee Payment Information</h4>
                <ul>
                    <li>Tuition: $500</li>
                    <li>Accommodation: $25</li>
                    <li>Miscellaneous: $15</li>
                </ul>
                <p>Payment methods:</p>
                <ul>
                    <li>Bank Transfer</li>
                    <li>Credit/Debit Card</li>
                </ul>
            </div>
        </div>
        <div id="documents" class="card" style="display: none;">
            <div class="card-body">
                <h4>Required Documents</h4>
                <ul>
                    <li>ID (e.g., passport)</li>
                    <li>Previous Academic Certificates</li>
                    <li>Birth Certificate</li>
                </ul>
            </div>
        </div>
        <div id="support" class="card" style="display: none;">
            <div class="card-body">
                <h4>Need Help?</h4>
                <p>Contact our support team:</p>
                <ul>
                    <li>Email: XXXXX@university.com</li>
                    <li>Phone: +255 745 299 753</li>
                </ul>
            </div>
        </div>
    </div>

    <script>
        function showContent(section) {
            const sections = document.querySelectorAll('.content .card');
            sections.forEach(sec => {
                if (sec.id === section) {
                    sec.style.display = 'block';
                } else {
                    sec.style.display = 'none';
                }
            });
        }
    </script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
</body>
</html>
