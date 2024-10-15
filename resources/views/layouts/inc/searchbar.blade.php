<section class="hero bg-dark-subtle py-5">
    <div class="container">

        <form action="{{ url('search') }}" method="GET">
            @csrf
            <div class="input-box mx-auto bg-body">
                <i class="bi bi-search"></i>

                <input type="text" name="keyword" value="{{ old('keyword') }}" placeholder="Search here..." />
                <button class="button">Search</button>
            </div>
        </form>

    </div>


</section>
