@switch($status)

    @case('Pending')
        <span class="badge bg-warning text-dark">
            Pending
        </span>
        @break

    @case('Assigned')
        <span class="badge bg-info">
            Assigned
        </span>
        @break

    @case('On Delivery')
        <span class="badge bg-primary">
            On Delivery
        </span>
        @break

    @case('Delivered')
        <span class="badge bg-success">
            Delivered
        </span>
        @break

    @case('Cancelled')
        <span class="badge bg-danger">
            Cancelled
        </span>
        @break

    @default
        <span class="badge bg-secondary">
            {{ $status }}
        </span>

@endswitch