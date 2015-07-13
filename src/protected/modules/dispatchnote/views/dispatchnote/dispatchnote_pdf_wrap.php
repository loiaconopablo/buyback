<?php $this->renderPartial(
    'dispatch_note_pdf', array(
    'dispatch_note' => $dispatch_note,
    'footer' => 'Original',
    )
);?>
<?php $this->renderPartial(
    'dispatch_note_pdf', array(
    'dispatch_note' => $dispatch_note,
    'footer' => 'Duplicado',
        )
);?>
<?php $this->renderPartial(
    'dispatch_note_pdf', array(
    'dispatch_note' => $dispatch_note,
    'footer' => 'Triplicado',
        )
);?>
