<?php
require_once __DIR__ . '/../includes/bootstrap.php';
require_role('student');
header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="report-card.pdf"');
// Basic PDF output for shared hosting compatibility (minimal syntax)
echo "%PDF-1.3\n1 0 obj<</Type/Catalog/Pages 2 0 R>>endobj\n2 0 obj<</Type/Pages/Count 1/Kids[3 0 R]>>endobj\n3 0 obj<</Type/Page/Parent 2 0 R/MediaBox[0 0 612 792]/Contents 4 0 R/Resources<</Font<</F1 5 0 R>>>>>>endobj\n4 0 obj<</Length 84>>stream\nBT /F1 18 Tf 50 730 Td (NovaSchool Premium Report Card) Tj 0 -30 Td (Generated: " . date('Y-m-d') . ") Tj ET\nendstream endobj\n5 0 obj<</Type/Font/Subtype/Type1/BaseFont/Helvetica>>endobj\nxref\n0 6\n0000000000 65535 f\ntrailer<</Root 1 0 R/Size 6>>\nstartxref\n400\n%%EOF";
