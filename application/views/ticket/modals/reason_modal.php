<!-- Reason Modal -->
<div class="modal fade" id="reasonModal" tabindex="-1" role="dialog" aria-labelledby="reasonModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title" id="reasonModalLabel">
                    <i class="fa fa-info-circle"></i> Status Change - Reason Required
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info">
                    <strong>Changing status to: <span id="targetStatusLabel"></span></strong>
                </div>
                <div class="form-group">
                    <label for="reasonText"><strong>Please provide a reason:</strong></label>
                    <textarea class="form-control" id="reasonText" rows="5"
                        placeholder="Explain why this status change is necessary..." required></textarea>
                    <small class="form-text text-muted">
                        This helps maintain transparency and accountability.
                    </small>
                </div>
                <div class="form-group">
                    <label><strong>Attachments (optional):</strong></label>
                    <div class="mb-2">
                        <button type="button" class="btn btn-sm btn-outline-secondary" id="btnAddReasonAttachment">
                            <i class="fa fa-paperclip"></i> Add Attachment
                        </button>
                        <input type="file" id="reasonAttachmentInput" style="display: none;">
                    </div>
                    <ul id="reasonAttachmentList" class="list-unstyled">
                        <!-- Attachments will be listed here -->
                    </ul>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-warning" id="submitReason">
                    <i class="fa fa-check"></i> Change Status
                </button>
            </div>
        </div>
    </div>
</div>