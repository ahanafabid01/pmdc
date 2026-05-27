<?php
/**
 * Shared announcement data for public listing and detail pages.
 */

function pmdc_get_announcements() {
    $items = [
        [
            'id' => 123,
            'title' => 'Admission Open for Session 2026-27',
            'category' => 'admission',
            'category_label' => 'Admission',
            'badge_label' => 'Urgent',
            'badge_class' => 'badge-urgent',
            'date' => '2026-02-08',
            'author' => 'Admission Office',
            'published' => true,
            'body' => "Applications are now open for HSC 1st Year admission in Science, Business, and Humanities groups for the 2026-27 academic session.\n\nEligible SSC or equivalent pass students are encouraged to complete the application process before the deadline. Required documents include academic transcripts, birth certificate, and recent photographs.\n\nFor details about eligibility, admission fee, and submission instructions, please contact the college office during working hours.",
            'attachment' => null,
        ],
        [
            'id' => 122,
            'title' => 'HSC Test Examination 2026 Schedule Released',
            'category' => 'academic',
            'category_label' => 'Academic',
            'badge_label' => 'New',
            'badge_class' => 'badge-new',
            'date' => '2026-02-06',
            'author' => 'Exam Committee',
            'published' => true,
            'body' => "The official test examination routine for HSC 2nd Year students has been published.\n\nStudents must collect admit cards from the academic office at least two days before the first exam date. Attendance in all scheduled exams is mandatory.\n\nAny student with unresolved fee dues should complete payment before collecting exam documents.",
            'attachment' => [
                'type' => 'pdf',
                'name' => 'HSC-Test-Exam-Schedule-2026.pdf',
                'size' => '432 KB',
                'url' => 'https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf',
            ],
        ],
        [
            'id' => 121,
            'title' => 'Annual Cultural Programme 2026',
            'category' => 'event',
            'category_label' => 'Event',
            'badge_label' => '',
            'badge_class' => '',
            'date' => '2026-02-05',
            'author' => 'Cultural Committee',
            'published' => true,
            'body' => "The annual cultural programme will be held at the college auditorium with performances from students across all departments.\n\nThe event includes music, drama, recitation, and group dance. Rehearsal slots are available from Sunday to Thursday after class hours.\n\nStudents interested in participating should register with the student affairs desk by February 12, 2026.",
            'attachment' => [
                'type' => 'image',
                'name' => 'annual-cultural-programme-2026.jpg',
                'size' => '1.8 MB',
                'url' => 'https://images.unsplash.com/photo-1514525253161-7a46d19cd819?w=1600&q=80',
            ],
        ],
        [
            'id' => 120,
            'title' => "Parents' Meeting Notice",
            'category' => 'notice',
            'category_label' => 'Notice',
            'badge_label' => 'Important',
            'badge_class' => 'badge-important',
            'date' => '2026-02-03',
            'author' => 'Principal Office',
            'published' => true,
            'body' => "A parents' meeting will be held on campus for guardians of HSC 1st and 2nd Year students.\n\nDiscussion topics include attendance, academic progress, exam preparation, and institutional policies. Parents are requested to attend with the student ID card.\n\nThe meeting will begin at 10:00 AM and conclude by 1:00 PM in the main seminar hall.",
            'attachment' => null,
        ],
        [
            'id' => 119,
            'title' => 'Scholarship Applications 2026 Now Open',
            'category' => 'admission',
            'category_label' => 'Admission',
            'badge_label' => '',
            'badge_class' => '',
            'date' => '2026-01-25',
            'author' => 'Finance Office',
            'published' => true,
            'body' => "Merit-based and need-based scholarship applications are now open for eligible students.\n\nApplicants must submit academic records, income statement, and recommendation documents within the stated deadline. Late submissions will not be accepted.\n\nPlease collect the scholarship form from the office and submit it by February 28, 2026.",
            'attachment' => null,
        ],
        [
            'id' => 118,
            'title' => 'Guest Lecture on Women Empowerment and Leadership',
            'category' => 'event',
            'category_label' => 'Event',
            'badge_label' => '',
            'badge_class' => '',
            'date' => '2026-01-22',
            'author' => 'Department of Social Science',
            'published' => true,
            'body' => "A special guest lecture on women empowerment and educational leadership will take place at the college campus.\n\nThe session will cover career confidence, leadership practices, and opportunities for higher education.\n\nAll HSC students are welcome to attend. Entry is free.",
            'attachment' => null,
        ],
        [
            'id' => 117,
            'title' => 'HSC Board Exam Results 2025 Published',
            'category' => 'academic',
            'category_label' => 'Academic',
            'badge_label' => '',
            'badge_class' => '',
            'date' => '2026-01-18',
            'author' => 'Academic Office',
            'published' => true,
            'body' => "Phulpur Mohila Degree College achieved a 92 percent pass rate in the HSC Annual Examination 2025.\n\nA total of 48 students secured GPA 5.00. The college congratulates all successful students and their families.\n\nDetailed result statements are available from the Results page and the academic office.",
            'attachment' => null,
        ],
        [
            'id' => 116,
            'title' => 'College Closed on National Holiday',
            'category' => 'notice',
            'category_label' => 'Notice',
            'badge_label' => '',
            'badge_class' => '',
            'date' => '2026-01-10',
            'author' => 'Administration',
            'published' => true,
            'body' => "The college will remain closed on the upcoming national holiday.\n\nRegular classes and office services will resume on the next working day.\n\nStudents are advised to plan their academic activities accordingly.",
            'attachment' => null,
        ],
        [
            'id' => 115,
            'title' => 'Draft Announcement Example',
            'category' => 'notice',
            'category_label' => 'Notice',
            'badge_label' => '',
            'badge_class' => '',
            'date' => '2026-01-09',
            'author' => 'Administration',
            'published' => false,
            'body' => "This unpublished record is intentionally excluded from public pages.",
            'attachment' => null,
        ],
    ];

    usort($items, static function($a, $b) {
        return strcmp($b['date'], $a['date']);
    });

    return $items;
}

function pmdc_get_published_announcements() {
    return array_values(array_filter(pmdc_get_announcements(), static function($item) {
        return !empty($item['published']);
    }));
}

function pmdc_find_published_announcement_by_id($id) {
    foreach (pmdc_get_published_announcements() as $item) {
        if ((int)$item['id'] === (int)$id) return $item;
    }
    return null;
}

