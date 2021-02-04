@foreach($items as $category)
    <div class="p-3 rounded">
        <table class="" width="100%" cellspacing="0">
            <thead>
            <tr>
                <th>{{ $category->name }}</th>
            </tr>
            </thead>
            <tbody class="accordion">
                @foreach($category->faqs as $faq)
                    <tr>
                        <td>
                            <div class="card mb-1">
                                <div class="card-header">
                                    <a data-toggle="collapse" href="#collapse{{ $faq->id }}" data-id="{{ $faq->id }}" class="btn-toggle-question">
                                        {!! $faq->question !!}
                                    </a>
                                </div>
                                <div id="collapse{{ $faq->id }}" class="collapse" data-id="{{ $faq->id }}" data-parent=".accordion">
                                    <div class="card-body">
                                        {!! $faq->answer !!}
                                    </div>
                                    <div class="card-footer text-right" id="faq-footer-{{ $faq->id }}">
                                        <span class="btn">Was this question helpful?</span>
                                        <div class="btn-group btn-group-sm">
                                            <a class="btn btn-success btn-helpful" href="#" data-id="{{ $faq->id }}" data-type="helpful_yes">
                                                <i class="uil uil-thumbs-up"></i> Yes
                                            </a>
                                            <a class="btn btn-danger btn-helpful" href="#" data-id="{{ $faq->id }}" data-type="helpful_no">
                                                <i class="uil uil-thumbs-down"></i> No
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endforeach
