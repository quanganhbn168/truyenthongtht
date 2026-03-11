<section class="review-section" id="reviews" aria-label="{{ $title }}">
    <div class="review-header">
        <h2 class="review-title">
            <i class="fa-regular fa-comments"></i>
            {{ $title }}
        </h2>
    </div>

    {{-- Form gửi bình luận --}}
    <div class="review-form-wrap">
        <h3 class="review-form-title">Để lại đánh giá của bạn</h3>
        <form class="review-form"
              id="review-form-{{ $model }}-{{ $modelId }}"
              data-model="{{ $model }}"
              data-model-id="{{ $modelId }}"
              novalidate>
            @csrf

            {{-- Rating stars --}}
            <div class="star-rating" role="group" aria-label="Đánh giá sao">
                @for($i = 5; $i >= 1; $i--)
                <input type="radio" name="rating" id="star{{ $i }}-{{ $modelId }}"
                       value="{{ $i }}" {{ $i === 5 ? 'checked' : '' }}>
                <label for="star{{ $i }}-{{ $modelId }}" aria-label="{{ $i }} sao">
                    <i class="fa-solid fa-star"></i>
                </label>
                @endfor
            </div>

            <div class="review-form-grid">
                <div class="form-group">
                    <label for="reviewer-name-{{ $modelId }}">Họ tên <span>*</span></label>
                    <input type="text" id="reviewer-name-{{ $modelId }}"
                           name="name" placeholder="Nguyễn Văn A" required>
                </div>
                <div class="form-group">
                    <label for="reviewer-email-{{ $modelId }}">Email</label>
                    <input type="email" id="reviewer-email-{{ $modelId }}"
                           name="email" placeholder="email@example.com">
                </div>
            </div>

            <div class="form-group">
                <label for="review-content-{{ $modelId }}">Nội dung <span>*</span></label>
                <textarea id="review-content-{{ $modelId }}"
                          name="content" rows="4"
                          placeholder="Chia sẻ trải nghiệm của bạn..." required></textarea>
            </div>

            <button type="submit" class="btn-submit-review">
                <i class="fa-solid fa-paper-plane"></i>
                Gửi đánh giá
            </button>
        </form>
    </div>

    {{-- Danh sách reviews --}}
    <div class="review-list" id="review-list-{{ $model }}-{{ $modelId }}">
        <p class="review-empty">Chưa có đánh giá nào. Hãy là người đầu tiên!</p>
    </div>
</section>

@push('scripts')
<script>
document.getElementById('review-form-{{ $model }}-{{ $modelId }}').addEventListener('submit', function(e) {
    e.preventDefault();
    const form = this;
    const data = new FormData(form);
    data.append('model_type', form.dataset.model);
    data.append('model_id', form.dataset.modelId);

    fetch('/reviews', {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                   'Accept': 'application/json' },
        body: data
    })
    .then(r => r.json())
    .then(res => {
        if (res.success) {
            Swal.fire({ icon: 'success', title: 'Cảm ơn!', text: res.message, timer: 2000, showConfirmButton: false });
            form.reset();
        } else {
            Swal.fire({ icon: 'error', title: 'Lỗi', text: res.message || 'Vui lòng thử lại.' });
        }
    })
    .catch(() => Swal.fire({ icon: 'error', title: 'Lỗi kết nối', text: 'Vui lòng thử lại sau.' }));
});
</script>
@endpush