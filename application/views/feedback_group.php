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

        #feedback-form input[type="text"] {
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
            margin-top: 20px;
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
            background: #ffffff;
            border-radius: 18px;
            padding: 20px;
            box-shadow: 0 4px 20px rgba(101, 46, 175, 0.15);
            transition: transform 0.3s ease;
            border-left: 6px solid #7c4dff;
            cursor: pointer;
        }

        .feedback-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 24px rgba(101, 46, 175, 0.2);
        }

        .feedback-card h4 {
            margin: 0 0 10px;
            font-size: 1.3rem;
            color: #4b0082;
        }

        .feedback-card ul {
            list-style-type: disc;
            padding-left: 20px;
            margin: 0 0 10px;
        }

        .feedback-card small {
            color: #777;
            font-size: 0.85rem;
        }

        #question-list {
            margin-top: 10px;
            max-height: 200px;
            overflow-y: auto;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background: #f7f7f7;
        }

        #question-list label {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            background: white;
            border-radius: 6px;
            padding: 10px;
            margin-bottom: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            transition: background 0.3s ease;
            cursor: pointer;
        }

        #question-list label:hover {
            background: #f0f0ff;
        }

        #question-list input[type="checkbox"] {
            margin-top: 4px;
            transform: scale(1.2);
        }

        b,
        strong {
            color: #652eaf;
            font-weight: bolder;
        }

        .submit-btn {
            background: linear-gradient(45deg, #7c4dff, #b388ff);
            color: white;
            border: none;
            padding: 12px 24px;
            font-size: 1rem;
            border-radius: 30px;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
            margin-top: 20px;
        }

        .submit-btn:hover {
            transform: scale(1.05);
            background: linear-gradient(45deg, #b388ff, #7c4dff);
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

<body onload="savegroup()">
    <header>
        <h1><i class="fa-solid fa-people-group"></i> Feedback Group</h1>
        <button class="top-right-button" onclick="toggleForm()">+ Create Group</button>
    </header>

    <!-- Feedback Modal Form -->
    <div id="feedback-form-container">
        <form id="feedback-form" onsubmit="submitGroup(event)">
            <h2>Create Group</h2>
            <input type="text" name="group_name" placeholder="Enter Group Name" required />
            <h3>Select Questions</h3>
            <div id="question-list"></div>
            <button type="submit" class="submit-btn">Save Group</button>
            <button type="button" class="close-form-btn" onclick="toggleForm()">&times;</button>
        </form>
    </div>

    <main>
        <div id="feedback-container"></div>
    </main>

    <script>
        function toggleForm() {
            const container = document.getElementById("feedback-form-container");
            const isVisible = container.style.display === "flex";
            container.style.display = isVisible ? "none" : "flex";
            if (!isVisible) loadQuestions();
        }

        function loadQuestions() {
            fetch("<?= base_url('View/get_feedback') ?>", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    }
                })
                .then(res => res.json())
                .then(data => {
                    const container = document.getElementById('question-list');
                    container.innerHTML = '';
                    data.forEach(q => {
                        const label = document.createElement('label');
                        const msg = q.message || '';
                        label.innerHTML = `
                            <input type="checkbox" name="questions[]" value="${q.id}">
                            <div>
                                <strong>${q.name}</strong><br>
                                <span>${(msg.length < 10) ? msg : msg.slice(0, 10) + "..."}</span>
                            </div>
                        `;
                        container.appendChild(label);
                    });
                })
                .catch(err => {
                    console.error("Error loading questions:", err);
                    alert("Failed to load questions.");
                });
        }

        function submitGroup(event) {
            event.preventDefault();
            const form = event.target;
            const name = form.group_name.value;
            const checkboxes = form.querySelectorAll('input[name="questions[]"]:checked');
            const question_ids = Array.from(checkboxes).map(cb => cb.value);

            if (question_ids.length === 0) {
                alert("Please select at least one question.");
                return;
            }

            fetch("<?= base_url('View/save_group') ?>", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                        group_name: name,
                        question_ids: question_ids
                    })
                })
                .then(res => res.json())
                .then(response => {
                    form.reset();
                    toggleForm();
                    savegroup();
                })
                .catch(err => {
                    console.error("Error saving group:", err);
                    alert("Failed to save group.");
                });
        }

        function savegroup() {
            fetch("<?= base_url('View/get_groups') ?>")
                .then(res => res.json())
                .then(data => {
                    const container = document.getElementById("feedback-container");
                    container.innerHTML = "";

                    if (!data || data.length === 0) {
                        container.innerHTML = '<p style="color: red;">No feedback group found.</p>';
                        return;
                    }

                    data.forEach(group => {
                        const questionsHTML = (group.messages || []).map(msg => `<li>${msg}</li>`).join("");
                        container.innerHTML += `
                            <div class="feedback-card" onclick="window.location.href='<?= base_url('View/group_detail/') ?>${group.id}'">
                                <h4><i class="fa-solid fa-folder-open"></i> ${group.name}</h4>
                                <ul>${questionsHTML}</ul>
                                <small><i class="fa fa-calendar"></i> ${group.created_at}</small>
                            </div>
                        `;
                    });
                })
                .catch(err => {
                    console.error("Error fetching groups:", err);
                    document.getElementById("feedback-container").innerHTML = '<p style="color: red;">Failed to load groups.</p>';
                });
        }
    </script>

</body>

</html>