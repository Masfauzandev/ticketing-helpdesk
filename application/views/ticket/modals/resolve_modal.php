<!-- Resolve Modal -->
<div class="modal fade" id="resolveModal" tabindex="-1" role="dialog" aria-labelledby="resolveModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="resolveModalLabel">
                    <i class="fa fa-check-circle"></i> Close Ticket - Resolution Required
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="resolveText"><strong>Please provide resolution details:</strong></label>
                    <textarea class="form-control" id="resolveText" rows="5"
                        placeholder="Describe what actions were taken to resolve this ticket..." required></textarea>
                    <small class="form-text text-muted">
                        This information will help document what was done to resolve the issue.
                    </small>
                </div>
                <div class="form-group">
                    <label><strong>Attachments (optional):</strong></label>
                    <div class="mb-2">
                        <button type="button" class="btn btn-sm btn-outline-secondary" id="btnAddResolveAttachment">
                            <i class="fa fa-paperclip"></i> Add Attachment
                        </button>
                        <input type="file" id="resolveAttachmentInput" style="display: none;">
                    </div>
                    <ul id="resolveAttachmentList" class="list-unstyled">
                        <!-- Attachments will be listed here -->
                    </ul>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" id="submitResolve">
                    <i class="fa fa-check"></i> Close Ticket
                </button>
            </div>
        </div>
    </div>
</div>