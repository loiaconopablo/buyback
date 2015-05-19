<?php $this->renderPartial(
    'dispatch_note_pdf', array(
    'dispatch_note' => $dispatch_note,
    'purchases' => $purchases,
    // 'company_from' => $company_from,
    'from' => $from,
    'to' => $to,
    'footer' => 'Original',
    )
);?>
<?php $this->renderPartial(
    'dispatch_note_pdf', array(
    'dispatch_note' => $dispatch_note,
    'purchases' => $purchases,
    // 'company_from' => $company_from,
    'from' => $from,
    'to' => $to,
    'footer' => 'Duplicado',
        )
);?>
<?php $this->renderPartial(
    'dispatch_note_pdf', array(
    'dispatch_note' => $dispatch_note,
    'purchases' => $purchases,
    // 'company_from' => $company_from,
    'from' => $from,
    'to' => $to,
    'footer' => 'Triplicado',
        )
);?>
