<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Management</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">Customer Management</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="GET" action="{{ route('customers.index') }}" class="mb-4 d-flex">
        <input type="text" name="search" class="form-control me-2" placeholder="Search by Name, Email, or Phone" value="{{ request('search') }}">
        <button type="submit" class="btn btn-primary">Search</button>
    </form>

    {{-- Add/Edit Form --}}
    <form method="POST" action="{{ route('customers.store') }}" class="mb-4">
        @csrf
        <input type="hidden" name="id" id="customer_id" value="">

        <div class="row g-3">
            <div class="col-md-4">
                <label for="customer_name" class="form-label">Customer Name</label>
                <input type="text" name="customer_name" id="customer_name" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" name="phone" id="phone" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label for="premium_amount" class="form-label">Premium Amount</label>
                <input type="number" name="premium_amount" id="premium_amount" class="form-control" step="0.01" required>
            </div>
            <div class="col-md-4">
                <label for="gst_percentage" class="form-label">GST % (Default 18%)</label>
                <input type="number" name="gst_percentage" id="gst_percentage" class="form-control" step="0.01" value="18">
            </div>
        </div>
        <button type="submit" class="btn btn-success mt-3">Save Customer</button>
    </form>

    <div class="mb-4">
        <form method="POST" action="{{ route('customers.import') }}" enctype="multipart/form-data" class="d-inline-block me-3">
            @csrf
            <input type="file" name="file" required>
            <button type="submit" class="btn btn-info">Import Excel</button>
        </form>
        <a href="{{ route('customers.export') }}" class="btn btn-warning">Export to Excel</a>
    </div>

    {{-- Customers Table --}}
    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>Customer Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Premium Amount</th>
            <th>GST %</th>
            <th>GST Amount</th>
            <th>Total Premium Collected</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @forelse($customers as $customer)
            <tr>
                <td>{{ $customer->id }}</td>
                <td>{{ $customer->customer_name }}</td>
                <td>{{ $customer->email }}</td>
                <td>{{ $customer->phone }}</td>
                <td>{{ $customer->premium_amount }}</td>
                <td>{{ $customer->gst_percentage }}</td>
                <td>{{ $customer->gst_amount }}</td>
                <td>{{ $customer->total_premium_collected }}</td>
                <td>
                    <button class="btn btn-primary btn-sm edit-btn"
                            data-id="{{ $customer->id }}"
                            data-name="{{ $customer->customer_name }}"
                            data-email="{{ $customer->email }}"
                            data-phone="{{ $customer->phone }}"
                            data-premium="{{ $customer->premium_amount }}"
                            data-gst="{{ $customer->gst_percentage }}">
                        Edit
                    </button>

                    <form method="POST" action="{{ route('customers.delete', $customer->id) }}" class="d-inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="9" class="text-center">No Customers Found</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $customers->links() }}
    </div>
</div>

<script>
    document.querySelectorAll('.edit-btn').forEach(button => {
        button.addEventListener('click', () => {
            document.getElementById('customer_id').value = button.dataset.id;
            document.getElementById('customer_name').value = button.dataset.name;
            document.getElementById('email').value = button.dataset.email;
            document.getElementById('phone').value = button.dataset.phone;
            document.getElementById('premium_amount').value = button.dataset.premium;
            document.getElementById('gst_percentage').value = button.dataset.gst;
        });
    });
</script>

</body>
</html>
