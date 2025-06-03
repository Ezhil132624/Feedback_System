<!DOCTYPE html>
<html lang="en">

<head>
    <title>Group Detail - <?= htmlspecialchars($group['name']) ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background: #f9f9f9;
            margin: 0;
        }

        a.back-link {
            display: inline-block;
            margin-bottom: 20px;
            color: #652eaf;
            text-decoration: none;
            font-weight: bold;
        }

        a.back-link:hover {
            text-decoration: underline;
        }

        .group-detail {
            max-width: 1000px;
            margin: 0 auto;
            padding: 10px;
        }

        .header-box {
            background: #fff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(101, 46, 175, 0.1);
            margin-bottom: 25px;
        }

        h1 {
            color: #652eaf;
            font-size: 1.8rem;
            margin: 0 0 10px;
        }

        h3 {
            font-size: 1.4rem;
            margin-top: 10px;
        }

        .question-card {
            background: #fff;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            transition: transform 0.2s;
        }

        .question-card:hover {
            transform: translateY(-3px);
        }

        .question-card h4 {
            margin: 0 0 10px;
            color: #333;
            font-size: 1.1rem;
        }

        .question-card p {
            margin: 0 0 15px;
            color: #555;
            font-size: 0.95rem;
        }

        .stars i {
            color: #ccc;
            cursor: pointer;
            font-size: 18px;
            transition: color 0.2s;
        }

        .stars i.active {
            color: #ffcc00;
        }

        .reply-box {
            margin-top: 25px;
            background: #fff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        .reply-box input[type="email"],
        .reply-box textarea {
            width: 100%;
            padding: 10px;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 0.9rem;
            margin-bottom: 10px;
            resize: vertical;
        }

        .reply-box button {
            background-color: #652eaf;
            color: #fff;
            padding: 8px 15px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.9rem;
        }

        .reply-box button:hover {
            background-color: #4a2191;
        }

        @media (max-width: 768px) {
            .group-detail {
                padding: 10px;
            }

            h1 {
                font-size: 1.5rem;
            }

            h3 {
                font-size: 1.2rem;
            }

            .question-card h4 {
                font-size: 1rem;
            }

            .question-card p {
                font-size: 0.9rem;
            }

            .reply-box input[type="email"],
            .reply-box textarea {
                font-size: 0.85rem;
            }

            .reply-box button {
                font-size: 0.85rem;
                float: right;
            }
        }

        @media (max-width: 480px) {

            .header-box,
            .question-card {
                padding: 15px;
            }

            .stars i {
                font-size: 16px;
            }
        }
    </style>
</head>

<body>

    <a href="<?= base_url('View/group'); ?>" class="back-link"><i class="fa fa-arrow-left"></i> Back to Groups</a>

    <div class="group-detail">
        <div class="header-box">
            <h1><i class="fa-solid fa-folder-open"></i> <?= htmlspecialchars($group['name']) ?></h1>
            <p><small><i class="fa fa-calendar"></i> Created At: <?= htmlspecialchars($group['created_at']) ?></small></p>
        </div>

        <h3>Selected Questions</h3>

        <?php if (!empty($group['questions'])): ?>
            <?php foreach ($group['questions'] as $q): ?>
                <div class="question-card" data-question-id="<?= $q['id'] ?>">
                    <h4><?= htmlspecialchars($q['name']) ?></h4>
                    <p><?= htmlspecialchars($q['message']) ?></p>

                    <!-- Star Rating -->
                    <div class="stars" data-question-id="<?= $q['id'] ?>">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <i class="fa fa-star" data-value="<?= $i ?>"></i>
                        <?php endfor; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No questions found for this group.</p>
        <?php endif; ?>

        <!-- Shared Reply Section -->
        <div class="reply-box">
            <input type="email" id="user-email" placeholder="Enter your email" required>
            <textarea id="user-reply" rows="3" placeholder="Write your reply for all questions..."></textarea>
            <button id="submit-feedback">Submit Feedback</button>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle star rating
            document.querySelectorAll('.stars').forEach(starBlock => {
                starBlock.addEventListener('click', function(e) {
                    if (e.target.classList.contains('fa-star')) {
                        const value = parseInt(e.target.getAttribute('data-value'));
                        const stars = this.querySelectorAll('i');

                        stars.forEach((star, index) => {
                            if (index < value) {
                                star.classList.add('active');
                            } else {
                                star.classList.remove('active');
                            }
                        });

                        this.setAttribute('data-selected-rating', value);
                    }
                });
            });

            // Submit feedback
            document.getElementById('submit-feedback').addEventListener('click', function() {
                const email = document.getElementById('user-email').value.trim();
                const reply = document.getElementById('user-reply').value.trim();
                const groupId = <?= (int)$group['id'] ?>;

                const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

                if (!email || !emailPattern.test(email)) {
                    alert("Please enter a valid email address.");
                    return;
                }

                if (!reply) {
                    alert("Please write your reply.");
                    return;
                }

                const feedbackData = [];

                document.querySelectorAll('.question-card').forEach(card => {
                    const questionId = card.getAttribute('data-question-id');
                    const stars = card.querySelector('.stars');
                    const rating = parseInt(stars.getAttribute('data-selected-rating')) || 0;

                    if (rating) {
                        feedbackData.push({
                            question_id: questionId,
                            rating: rating,
                            reply: reply
                        });
                    }
                });

                if (feedbackData.length === 0) {
                    alert("Please rate at least one question.");
                    return;
                }

                fetch("<?= base_url('View/save_group_feedback') ?>", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify({
                            group_id: groupId,
                            email: email,
                            feedback: feedbackData
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            alert("Feedback submitted successfully!");
                            window.location.href = "<?= base_url('View/feedback_answer/'); ?>" + groupId;
                        } else {
                            alert("Error saving feedback.");
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        alert("AJAX error.");
                    });
            });
        });
    </script>


</body>

</html>