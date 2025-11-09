CREATE TABLE `user` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin') NOT NULL DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `user` (`id`, `username`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'TDW', 'thenuriwelagedara12@gmail.com', '$2y$10$mnYA1HxUZljV3bix0vYxIOTa2.vX1K7eBoCmWVVdUOPUr/iVU/nsy', 'user', '2025-11-05 08:31:39'),
(2, 'SP', 'sp@gmail.com', '$2y$10$hmal4ndRtoGcHnoy6m4fUuuLNOKkHTY0kOd8ZRjpy.rsKG3mpbcI.', 'user', '2025-11-05 08:50:42'),
(7, 'dhananjiwelagedara', 'dhananji3612@gmail.com', '$2y$10$bvrMxCsh6Cjwqp/v60iAh.EsOF//qQ8UhtTAECzZJZj4CFAKTWCkq', 'user', '2025-11-09 10:02:40');


CREATE TABLE `blogpost` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `blogpost` (`id`, `user_id`, `title`, `content`, `created_at`, `updated_at`) VALUES
(2, 2, 'Time Management Strategies for Students', 'Balancing classes, assignments, part-time jobs, and extracurricular activities can feel overwhelming for university students. Effective time management is key to maintaining productivity without burnout.\r\n\r\nSome strategies include:\r\n\r\nCreating a weekly plan: Map out classes, study sessions, and personal commitments to visualize your workload.\r\n\r\nPrioritizing tasks: Use tools like the Eisenhower Matrix to focus on what is important rather than just urgent.\r\n\r\nBreaking tasks into smaller steps: Large projects become more manageable when divided into smaller, achievable goals.\r\n\r\nLimiting distractions: Identify time-wasters such as excessive social media use and replace them with focused study blocks.\r\n\r\nMastering time management not only improves academic performance but also frees up time for social activities, hobbies, and self-care, fostering a more balanced and fulfilling university experience.', '2025-11-05 11:48:25', '2025-11-08 17:22:30'),
(5, 1, 'Using LinkedIn to Build Your Professional Future', 'LinkedIn is more than a digital resume; it is a platform for networking, learning, and personal branding. Students can leverage LinkedIn to build a professional identity even before graduation.\r\n\r\nEffective strategies include:\r\n\r\nCompleting your profile: Include a professional photo, a compelling headline, and a clear summary of skills and interests.\r\n\r\nConnecting strategically: Reach out to classmates, professors, alumni, and professionals in fields of interest. Personalized messages often create stronger connections.\r\n\r\nEngaging with content: Share articles, comment thoughtfully on posts, or write short reflections to demonstrate knowledge and curiosity.\r\n\r\nExploring opportunities: Use LinkedIn’s job and internship search features to find relevant experiences, and follow companies or organizations to stay updated.\r\n\r\nBy actively participating on LinkedIn, students can create a strong professional presence, expand their network, and uncover opportunities that align with their career goals.', '2025-11-08 17:04:08', NULL),
(6, 1, 'Mastering Cloud Computing as a Student', 'Cloud computing skills are highly valued across IT fields, including software development, data science, and DevOps. Learning cloud platforms early gives students a significant edge in the job market.\r\n\r\nSteps to gain proficiency:\r\n\r\nExplore major platforms: AWS, Azure, and Google Cloud offer free student tiers, tutorials, and labs.\r\n\r\nHands-on projects: Deploy simple websites, databases, or microservices to understand cloud architecture.\r\n\r\nLearn DevOps basics: Familiarize yourself with CI/CD pipelines, containerization with Docker, and orchestration with Kubernetes.\r\n\r\nDocument and showcase projects: Create a portfolio of cloud-based projects to demonstrate skills to recruiters or in interviews.\r\n\r\nAs an example a student could deploy a Flask web application on AWS using EC2, set up an S3 bucket for storage, and automate deployments with GitHub Actions. This demonstrates not only coding skills but also practical cloud expertise.\r\n\r\nMastering cloud computing prepares students for internships, hackathons, and full-time roles in technology companies.', '2025-11-08 17:08:36', '2025-11-09 05:45:55');

ALTER TABLE `blogpost`
  AUTO_INCREMENT = 11;

ALTER TABLE `user`
  AUTO_INCREMENT = 8;

COMMIT;

