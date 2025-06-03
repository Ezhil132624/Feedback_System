<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background: #f9f9f9;
        }

        header {
            background-color: #652eaf;
            padding: 20px;
            color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
        }

        header h1 {
            margin: 0;
            font-size: 2rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .top-right-button {
            background: linear-gradient(45deg, #7c4dff, #b388ff);
            color: white;
            padding: 10px 20px;
            border-radius: 30px;
            border: none;
            cursor: pointer;
            font-size: 1rem;
            transition: 0.3s ease;
            white-space: nowrap;
        }

        .top-right-button:hover {
            transform: scale(1.05);
            background: linear-gradient(45deg, #b388ff, #7c4dff);
        }

        #feedback-form-container {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            background: rgba(0, 0, 0, 0.6);
            width: 100%;
            height: 100%;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        #feedback-form {
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            max-width: 400px;
            width: 90%;
            position: relative;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
        }

        #feedback-form input,
        #feedback-form textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 6px;
            border: 1px solid #ccc;
        }

        #feedback-form button[type="submit"] {
            background: #652eaf;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            cursor: pointer;
            float: right;
        }

        #feedback-form button[type="submit"]:hover {
            background: #4e1f85;
        }

        .close-form-btn {
            position: absolute;
            top: 10px;
            right: 12px;
            font-size: 24px;
            background: none;
            border: none;
            color: #652eaf;
            cursor: pointer;
        }

        #feedback-container {
            padding: 20px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
        }

        .feedback-card {
            background: #e7dfdf;
            border-radius: 16px;
            padding: 20px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            display: flex;
            flex-direction: column;
            gap: 12px;
            position: relative;
        }

        .feedback-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
        }

        .feedback-card h4 {
            margin: 0;
            font-size: 1.2rem;
            color: #4b0082;
            border-bottom: 2px solid #eee;
            padding-bottom: 6px;
        }

        .feedback-card p {
            font-size: 1rem;
            color: #333;
            margin: 0;
            line-height: 1.5;
        }

        .feedback-card small {
            font-size: 0.85rem;
            color: #777;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .feedback-card small i {
            color: #652eaf;
        }


        @media (max-width: 600px) {
            header {
                flex-direction: column;
                align-items: flex-start;
            }

            header h1 {
                font-size: 1.5rem;
            }

            .top-right-button {
                width: 100%;
                text-align: center;
            }

            #feedback-form {
                width: 90%;
            }
        }
    </style>
</head>

<body>

    <header>
        <h1><i class="fa-regular fa-comments"></i> User Feedback</h1>
        <button class="top-right-button" onclick="toggleForm()">+ New Question</button>
    </header>

    <!-- Feedback Modal Form -->
    <div id="feedback-form-container">
        <form id="feedback-form" onsubmit="submitFeedback(event)">
            <button type="button" class="close-form-btn" onclick="toggleForm()">×</button>
            <h3>Ask a Question</h3>
            <input type="text" id="name" placeholder="Your Name" required />
            <textarea id="message" placeholder="Your Question" rows="4" required></textarea>
            <button type="submit">Submit</button>
        </form>
    </div>

    <main>
        <div id="feedback-container"></div>
    </main>

    <script>
        function toggleForm() {
            const container = document.getElementById("feedback-form-container");
            container.style.display = container.style.display === "flex" ? "none" : "flex";
        }

        function submitFeedback(e) {
            e.preventDefault();
            const name = document.getElementById("name").value.trim();
            const message = document.getElementById("message").value.trim();

            if (!name || !message) return;

            fetch("<?= base_url('View/add_feedback') ?>", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                        name,
                        message
                    })
                })
                .then(res => res.json())
                .then(res => {
                    if (res.status === "success") {
                        document.getElementById("feedback-form").reset();
                        toggleForm();
                        loadFeedback();
                    } else {
                        alert("Submission failed. Try again.");
                    }
                })
                .catch(err => {
                    console.error("Submit error:", err);
                });
        }

        function loadFeedback() {
            fetch("<?= base_url('View/get_feedback') ?>")
                .then(res => res.json())
                .then(data => {
                    const container = document.getElementById("feedback-container");
                    container.innerHTML = "";
                    if (data.length === 0) {
                        container.innerHTML = '<p style="color: red;">No feedback question found.</p>';
                        return;
                    }

                    data.forEach(item => {
                        const msg = item.message;
                        container.innerHTML += `
                    <div class="feedback-card">
                        <h4>${item.name}</h4>
                        
                        <p>${(msg.length < 25) ? msg : msg.slice(0, 25) + "..."}</p>
                        <small><i class="fa fa-calendar"></i> ${item.created_at}</small>
                    </div>
                `;
                    });
                })
                .catch(err => {
                    console.error("Load error:", err);
                });
        }

        document.addEventListener("DOMContentLoaded", () => {
            loadFeedback();
            document.getElementById("feedback-form-container").style.justifyContent = "center";
        });
    </script>

</body>

</html>