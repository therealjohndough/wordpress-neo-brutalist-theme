/**
 * Brand Clarity Quiz - Result Capture
 * Intercepts quiz completion and captures results server-side
 */

(function($) {
    'use strict';

    // Wait for quiz to be fully loaded
    $(document).ready(function() {

        // Store quiz data as it progresses
        window.quizData = {
            scores: {
                branding: 0,
                strategy: 0,
                marketing: 0
            },
            answers: [],
            budget_level: '',
            urgency: ''
        };

        // Intercept answer selections
        $(document).on('click', '.quiz-option', function() {
            const questionIndex = $(this).closest('.quiz-question').index();
            const answer = $(this).data('answer');

            // Store answer
            window.quizData.answers[questionIndex] = answer;

            // Update scores based on answer (this matches your quiz logic)
            const scores = $(this).data('scores');
            if (scores) {
                window.quizData.scores.branding += scores.branding || 0;
                window.quizData.scores.strategy += scores.strategy || 0;
                window.quizData.scores.marketing += scores.marketing || 0;
            }

            // Capture budget and urgency from specific questions
            if (questionIndex === 3) { // Budget question
                window.quizData.budget_level = $(this).data('budget-level') || '';
            }
            if (questionIndex === 4) { // Timeline question
                window.quizData.urgency = $(this).data('urgency') || '';
            }
        });

        // Intercept quiz completion
        window.addEventListener('quiz_complete', function(e) {
            console.log('Quiz completed, capturing results...');
            handleQuizCompletion(e.detail || window.quizData);
        });

        // Also listen for GTM dataLayer pushes
        if (window.dataLayer) {
            const originalPush = window.dataLayer.push;
            window.dataLayer.push = function() {
                const args = Array.prototype.slice.call(arguments);

                // Check if this is a quiz_complete event
                args.forEach(function(item) {
                    if (item && item.event === 'quiz_complete') {
                        console.log('=== QUIZ COMPLETE DEBUG ===');
                        console.log('Full dataLayer item:', JSON.stringify(item, null, 2));
                        console.log('topCategory:', item.topCategory);
                        console.log('budget:', item.budget);
                        console.log('urgency:', item.urgency);
                        console.log('answers:', item.answers);
                        console.log('===========================');
                        handleQuizCompletion(item);
                    }
                });

                return originalPush.apply(window.dataLayer, args);
            };
        }

        /**
         * Show email capture modal on quiz completion
         */
        function handleQuizCompletion(quizResults) {
            console.log('handleQuizCompletion called with:', quizResults);

            // Get top need from dataLayer event or calculate from scores
            let topNeed = quizResults.topCategory || 'branding';

            // Create scores object - if coming from GTM, use topCategory
            let scores = {
                branding: 0,
                strategy: 0,
                marketing: 0
            };

            // Set score based on top category (GTM doesn't send actual scores, just winner)
            if (topNeed === 'branding') {
                scores.branding = 100;
            } else if (topNeed === 'strategy') {
                scores.strategy = 100;
            } else if (topNeed === 'marketing') {
                scores.marketing = 100;
            }

            // Get budget and urgency from GTM event
            const budget = quizResults.budget || 'not-specified';
            const urgency = quizResults.urgency || 'not-specified';

            console.log('Parsed quiz data:', { topNeed, scores, budget, urgency });

            // Show email capture modal
            showEmailCaptureModal(topNeed, scores, budget, urgency);
        }

        /**
         * Display email capture modal
         */
        function showEmailCaptureModal(topNeed, scores, budget, urgency) {
            const modalHTML = `
                <div id="quiz-email-modal" style="
                    position: fixed;
                    top: 0;
                    left: 0;
                    right: 0;
                    bottom: 0;
                    background: rgba(0, 0, 0, 0.8);
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    z-index: 10000;
                    backdrop-filter: blur(4px);
                ">
                    <div style="
                        background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
                        border: 2px solid rgba(249, 115, 22, 0.3);
                        border-radius: 16px;
                        padding: 3rem;
                        max-width: 500px;
                        width: 90%;
                        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
                    ">
                        <h2 style="
                            color: #f97316;
                            margin: 0 0 1rem 0;
                            font-size: 1.75rem;
                            font-weight: 700;
                        ">Get Your Personalized Results</h2>

                        <p style="
                            color: #d1d5db;
                            margin: 0 0 2rem 0;
                            line-height: 1.6;
                        ">We'll email you a detailed breakdown of your ${topNeed} needs and next steps.</p>

                        <form id="quiz-email-form">
                            <div style="margin-bottom: 1rem;">
                                <label style="
                                    display: block;
                                    color: #9ca3af;
                                    margin-bottom: 0.5rem;
                                    font-size: 0.875rem;
                                    font-weight: 600;
                                ">Name</label>
                                <input type="text" name="name" placeholder="Your name" required style="
                                    width: 100%;
                                    padding: 0.75rem;
                                    background: rgba(255, 255, 255, 0.05);
                                    border: 1px solid rgba(255, 255, 255, 0.1);
                                    border-radius: 8px;
                                    color: #fff;
                                    font-size: 1rem;
                                ">
                            </div>

                            <div style="margin-bottom: 1rem;">
                                <label style="
                                    display: block;
                                    color: #9ca3af;
                                    margin-bottom: 0.5rem;
                                    font-size: 0.875rem;
                                    font-weight: 600;
                                ">Email Address *</label>
                                <input type="email" name="email" placeholder="your@email.com" required style="
                                    width: 100%;
                                    padding: 0.75rem;
                                    background: rgba(255, 255, 255, 0.05);
                                    border: 1px solid rgba(255, 255, 255, 0.1);
                                    border-radius: 8px;
                                    color: #fff;
                                    font-size: 1rem;
                                ">
                            </div>

                            <div style="margin-bottom: 2rem;">
                                <label style="
                                    display: block;
                                    color: #9ca3af;
                                    margin-bottom: 0.5rem;
                                    font-size: 0.875rem;
                                    font-weight: 600;
                                ">Company (Optional)</label>
                                <input type="text" name="company" placeholder="Company name" style="
                                    width: 100%;
                                    padding: 0.75rem;
                                    background: rgba(255, 255, 255, 0.05);
                                    border: 1px solid rgba(255, 255, 255, 0.1);
                                    border-radius: 8px;
                                    color: #fff;
                                    font-size: 1rem;
                                ">
                            </div>

                            <button type="submit" style="
                                width: 100%;
                                padding: 1rem;
                                background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
                                color: white;
                                border: none;
                                border-radius: 8px;
                                font-size: 1rem;
                                font-weight: 700;
                                cursor: pointer;
                                transition: transform 0.2s;
                            ">Get My Results</button>

                            <button type="button" id="quiz-skip-btn" style="
                                width: 100%;
                                margin-top: 1rem;
                                padding: 0.75rem;
                                background: transparent;
                                color: #9ca3af;
                                border: 1px solid rgba(255, 255, 255, 0.1);
                                border-radius: 8px;
                                font-size: 0.875rem;
                                cursor: pointer;
                            ">Skip for now</button>

                            <div id="quiz-submit-message" style="
                                margin-top: 1rem;
                                padding: 0.75rem;
                                border-radius: 8px;
                                display: none;
                            "></div>
                        </form>
                    </div>
                </div>
            `;

            $('body').append(modalHTML);

            // Handle form submission
            $('#quiz-email-form').on('submit', function(e) {
                e.preventDefault();

                const formData = {
                    action: 'csl_submit_quiz',
                    nonce: cslQuiz.nonce,
                    name: $(this).find('[name="name"]').val(),
                    email: $(this).find('[name="email"]').val(),
                    company: $(this).find('[name="company"]').val(),
                    branding_score: scores.branding || 0,
                    strategy_score: scores.strategy || 0,
                    marketing_score: scores.marketing || 0,
                    top_need: topNeed,
                    budget_level: budget || 'not-specified',
                    urgency: urgency || 'not-specified'
                };

                console.log('Submitting quiz data:', formData);

                // Disable submit button
                const $submitBtn = $(this).find('[type="submit"]');
                $submitBtn.prop('disabled', true).text('Sending...');

                // Submit via AJAX
                $.ajax({
                    url: cslQuiz.ajax_url,
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            // Show success message
                            $('#quiz-submit-message')
                                .css({
                                    'background': 'rgba(34, 197, 94, 0.1)',
                                    'border': '1px solid #22c55e',
                                    'color': '#22c55e'
                                })
                                .text('✓ Results saved! Redirecting to contact page...')
                                .show();

                            // Redirect to contact page after delay
                            setTimeout(function() {
                                window.location.href = response.data.contact_url;
                            }, 2000);
                        } else {
                            throw new Error(response.data.message || 'Submission failed');
                        }
                    },
                    error: function(xhr, status, error) {
                        $('#quiz-submit-message')
                            .css({
                                'background': 'rgba(239, 68, 68, 0.1)',
                                'border': '1px solid #ef4444',
                                'color': '#ef4444'
                            })
                            .text('Error: ' + (error || 'Please try again'))
                            .show();

                        $submitBtn.prop('disabled', false).text('Get My Results');
                    }
                });
            });

            // Handle skip button
            $('#quiz-skip-btn').on('click', function() {
                $('#quiz-email-modal').fadeOut(300, function() {
                    $(this).remove();
                });
            });
        }

    });

})(jQuery);
