<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <style>
        /* Reset */
        * {
            box-sizing: border-box;
        }

        html,
        body {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f9f9f9 0%, #f9f9f9 100%);
            color: #333;
            overflow: hidden;
        }

        body {
            display: flex;
            flex-direction: column;
            height: 100vh;
            overflow-y: auto;
        }

        .container {
            width: 100%;
            height: 100%;
            padding: 30px 40px;
            display: flex;
            flex-direction: column;
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

        .cards {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
            flex-grow: 1;
            overflow-y: auto;
            padding-right: 10px;
        }

        @media (max-width: 900px) {
            .cards {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 480px) {
            .cards {
                grid-template-columns: 1fr;
            }
        }

        .card {
            background: linear-gradient(135deg, #ede7f6, #d1c4e9);
            border-radius: 20px;
            padding: 28px 30px;
            box-shadow: 0 4px 15px rgba(149, 117, 205, 0.3);
            color: #4a3f6b;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: box-shadow 0.3s ease;
        }

        .card:hover {
            box-shadow: 0 10px 30px rgba(149, 117, 205, 0.5);
            cursor: default;
        }

        .card-title {
            font-weight: 700;
            font-size: 1.4rem;
            margin-bottom: 15px;
            color: #621da3;
            border-bottom: 2px solid #b39ddb;
            padding-bottom: 8px;
        }

        .card-row {
            margin-bottom: 14px;
            font-size: 1.1rem;
            color: #5e548e;
        }

        .label {
            font-weight: 600;
            color: #621da3;
            margin-right: 8px;
        }

        .reply {
            background: #d7c6f0;
            padding: 12px 18px;
            border-radius: 14px;
            font-style: italic;
            color: #4b3b71;
            margin-top: 12px;
            white-space: pre-wrap;
        }

        .created-at {
            font-size: 0.9rem;
            color: #7c6fbf;
            text-align: right;
            margin-top: auto;
        }

        .stars {
            color: #9575cd;
        }

        .stars .full-star {
            color: #7e57c2;
        }

        .stars>span:hover,
        .stars>span:hover~span {
            color: #f1c40f;
        }

        .stars .full-star {
            color: rgb(255, 0, 0);
            position: relative;
            z-index: 1;
        }

        .cards::-webkit-scrollbar {
            width: 8px;
        }

        .cards::-webkit-scrollbar-thumb {
            background-color: #6c3483cc;
            border-radius: 10px;
        }

        @media (max-width: 480px) {
            h2 {
                font-size: 2.2rem;
            }

            .card {
                padding: 20px 22px;
            }

            .card-title {
                font-size: 1.15rem;
            }
        }
    </style>
</head>

<body>

    <header>
        <h2><i class="fas fa-eye"></i> Feedback Answers</h2>
    </header>

    <div class="container" role="main" aria-label="Feedback Answers Cards">
        <div class="cards" id="cards-container">
            <p>Loading feedback answers...</p>
        </div>
    </div>

    <script>
        function createStarRating(rating) {
            const maxStars = 5;
            let starsHtml = '<span class="stars" aria-label="Rating: ' + rating + ' out of 5 stars" role="img">';
            for (let i = 1; i <= maxStars; i++) {
                if (i <= rating) {
                    starsHtml += '<span class="full-star">&#9733;</span>';
                } else {
                    starsHtml += '<span>&#9733;</span>';
                }
            }
            starsHtml += '</span>';
            return starsHtml;
        }

        fetch('<?= base_url("View/get_feedback_answers_json") ?>')
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok: ' + response.statusText);
                return response.json();
            })
            .then(data => {
                const container = document.getElementById('cards-container');
                container.innerHTML = '';

                if (!data.length) {
                    container.innerHTML = '<p style=" font-size:1.2rem; color:red;">No feedback answers found.</p>';
                    return;
                }

                // Group answers by group_id + created_at
                const grouped = {};
                data.forEach(ans => {
                    const key = `${ans.email}_${ans.created_at}`;
                    if (!grouped[key]) {
                        grouped[key] = {
                            group_id: ans.group_id,
                            created_at: ans.created_at,
                            reply: ans.reply,
                            email: ans.email, // <-- Add email here
                            questions: []
                        };
                    }
                    grouped[key].questions.push({
                        message: ans.message,
                        rating: ans.rating
                    });
                });

                // Render each submission as one card
                Object.values(grouped).forEach(entry => {
                    const card = document.createElement('article');
                    card.classList.add('card');

                    let questionsHtml = '';
                    entry.questions.forEach(q => {
                        questionsHtml += `
                        <div class="card-row"><span class="label">Question:</span> ${q.message}</div>
                        <div class="card-row"><span class="label">Rating:</span> ${createStarRating(q.rating)}</div>
                        <hr style="border:none; border-top:1px solid #c5b7e0; margin:10px 0;">
                    `;
                    });

                    card.innerHTML = `
    <div class="card-title">Group ID: ${entry.group_id}</div>
    <div class="card-row"><span class="label">Email:</span> ${entry.email}</div>
    ${questionsHtml}
    <div class="card-row"><span class="label">Reply:</span>
        <div class="reply">${entry.reply || 'No reply'}</div>
    </div>
    <div class="created-at">${entry.created_at}</div>
`;

                    container.appendChild(card);
                });
            })
            .catch(err => {
                console.error('Fetch error:', err);
                const container = document.getElementById('cards-container');
                container.innerHTML = '<p style="color: red; text-align:center;">Error loading data.</p>';
            });
    </script>

</body>

</html>