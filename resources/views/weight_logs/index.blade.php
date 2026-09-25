<x-weight>
    <x-slot:title>
        ติดตามน้ำหนักร่างกาย - Weight Tracker
    </x-slot:title>

    <!-- แจ้งเตือน Success Status -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4">
        <!-- ฝั่งซ้าย: ฟอร์มเพิ่ม/แก้ไขข้อมูล -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-header {{ isset($editLog) ? 'bg-warning text-dark' : 'bg-primary text-white' }}">
                    <h5 class="card-title mb-0">
                        {{ isset($editLog) ? '✏️ แก้ไขข้อมูลน้ำหนัก' : '➕ บันทึกน้ำหนักใหม่' }}
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ isset($editLog) ? route('weights.update', $editLog->id) : route('weights.store') }}" method="POST">
                        @csrf
                        @if(isset($editLog))
                            @method('PUT')
                        @endif

                        <!-- วันที่บันทึก -->
                        <div class="mb-3">
                            <label for="recorded_at" class="form-label">วันที่บันทึก <span class="text-danger">*</span></label>
                            <input type="date" 
                                   class="form-control @error('recorded_at') is-invalid @enderror" 
                                   id="recorded_at" 
                                   name="recorded_at" 
                                   value="{{ old('recorded_at', $editLog->recorded_at ?? date('Y-m-d')) }}">
                            @error('recorded_at')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- น้ำหนัก -->
                        <div class="mb-3">
                            <label for="weight" class="form-label">น้ำหนัก (กิโลกรัม) <span class="text-danger">*</span></label>
                            <input type="number" 
                                   step="0.1" 
                                   class="form-control @error('weight') is-invalid @enderror" 
                                   id="weight" 
                                   name="weight" 
                                   placeholder="เช่น 65.5"
                                   value="{{ old('weight', $editLog->weight ?? '') }}">
                            @error('weight')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- หมายเหตุ -->
                        <div class="mb-3">
                            <label for="note" class="form-label">หมายเหตุ</label>
                            <textarea class="form-control @error('note') is-invalid @enderror" 
                                      id="note" 
                                      name="note" 
                                      rows="2" 
                                      placeholder="เช่น ออกกำลังกายเช้า">{{ old('note', $editLog->note ?? '') }}</textarea>
                            @error('note')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- ปุ่มบันทึก -->
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn {{ isset($editLog) ? 'btn-warning' : 'btn-primary' }}">
                                {{ isset($editLog) ? 'อัปเดตข้อมูล' : 'บันทึกข้อมูล' }}
                            </button>
                            @if(isset($editLog))
                                <a href="{{ route('weights.index') }}" class="btn btn-outline-secondary">ยกเลิกการแก้ไข</a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- ฝั่งขวา: แสดงกราฟ และ ตารางข้อมูล -->
        <div class="col-md-8">
            <!-- Google Chart Card -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">📊 กราฟแสดงแนวโน้มน้ำหนัก</h5>
                </div>
                <div class="card-body">
                    <div id="curve_chart" style="width: 100%; height: 300px"></div>
                </div>
            </div>

            <!-- ตารางแสดงรายการน้ำหนัก -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">📋 ประวัติการบันทึกน้ำหนัก</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>วันที่</th>
                                    <th>น้ำหนัก (กก.)</th>
                                    <th>หมายเหตุ</th>
                                    <th class="text-center">จัดการ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($logs as $log)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($log->recorded_at)->format('d/m/Y') }}</td>
                                        <td><span class="badge bg-info text-dark fs-6">{{ number_format($log->weight, 1) }} kg</span></td>
                                        <td>{{ $log->note ?? '-' }}</td>
                                        <td class="text-center">
                                            <!-- ปุ่มแก้ไข -->
                                            <a href="{{ route('weights.index', ['edit' => $log->id]) }}" class="btn btn-sm btn-outline-warning">
                                                แก้ไข
                                            </a>
                                            
                                            <!-- ปุ่มลบ -->
                                            <form action="{{ route('weights.destroy', $log->id) }}" method="POST" class="d-inline" onsubmit="return confirm('ยืนยันการลบข้อมูลนี้หรือไม่?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">ลบ</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-4">ยังไม่มีข้อมูลการบันทึกน้ำหนัก</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- สคริปต์ Google Chart -->
    @push('scripts')
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['วันที่', 'น้ำหนัก (กก.)'],
                @foreach($chartData as $item)
                    ['{{ \Carbon\Carbon::parse($item->recorded_at)->format("d/m") }}', {{ $item->weight }}],
                @endforeach
            ]);

            var options = {
                title: 'พัฒนาการน้ำหนักตามเวลา',
                curveType: 'function',
                legend: { position: 'bottom' },
                hAxis: { title: 'วันที่' },
                vAxis: { title: 'น้ำหนัก (กก.)' },
                colors: ['#0d6efd'],
                pointSize: 5
            };

            var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));
            chart.draw(data, options);
        }
    </script>
    @endpush
</x-weight>