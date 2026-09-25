<?php

namespace App\Http\Controllers;

use App\Models\WeightLog;
use Illuminate\Http\Request;

class WeightLogController extends Controller
{
    // แสดงรายการข้อมูล + หน้าเพิ่ม/แก้ไข + Google Chart
    public function index(Request $request)
    {
        // ข้อมูลสำหรับตาราง (เรียงจากวันที่ล่าสุด)
        $logs = WeightLog::orderBy('recorded_at', 'desc')->get();

        // ข้อมูลสำหรับ Google Chart (เรียงจากอดีตไปปัจจุบัน)
        $chartData = WeightLog::orderBy('recorded_at', 'asc')->get();

        // ตรวจสอบว่ามี parameter edit ส่งมาหรือไม่
        $editLog = null;
        if ($request->has('edit')) {
            $editLog = WeightLog::find($request->query('edit'));
        }

        return view('weight_logs.index', compact('logs', 'chartData', 'editLog'));
    }

    // จัดการ Form validation & เพิ่มข้อมูลใหม่
    public function store(Request $request)
    {
        $validated = $request->validate([
            'recorded_at' => 'required|date',
            'weight' => 'required|numeric|min:20|max:300',
            'note' => 'nullable|string|max:255',
        ], [
            'recorded_at.required' => 'กรุณาระบุวันที่บันทึก',
            'recorded_at.date' => 'รูปแบบวันที่ไม่ถูกต้อง',
            'weight.required' => 'กรุณาระบุน้ำหนัก',
            'weight.numeric' => 'น้ำหนักต้องเป็นตัวเลขเท่านั้น',
            'weight.min' => 'น้ำหนักต้องไม่น้อยกว่า 20 กิโลกรัม',
            'weight.max' => 'น้ำหนักต้องไม่เกิน 300 กิโลกรัม',
            'note.max' => 'หมายเหตุต้องมีความยาวไม่เกิน 255 ตัวอักษร',
        ]);

        WeightLog::create($validated);

        return redirect()->route('weights.index')->with('success', 'บันทึกข้อมูลน้ำหนักเรียบร้อยแล้ว!');
    }

    // จัดการ Form validation & อัปเดตข้อมูล
    public function update(Request $request, WeightLog $weightLog)
    {
        $validated = $request->validate([
            'recorded_at' => 'required|date',
            'weight' => 'required|numeric|min:20|max:300',
            'note' => 'nullable|string|max:255',
        ], [
            'recorded_at.required' => 'กรุณาระบุวันที่บันทึก',
            'weight.required' => 'กรุณาระบุน้ำหนัก',
            'weight.numeric' => 'น้ำหนักต้องเป็นตัวเลขเท่านั้น',
            'weight.min' => 'น้ำหนักต้องไม่น้อยกว่า 20 กิโลกรัม',
            'weight.max' => 'น้ำหนักต้องไม่เกิน 300 กิโลกรัม',
        ]);

        $weightLog->update($validated);

        return redirect()->route('weights.index')->with('success', 'อัปเดตข้อมูลเรียบร้อยแล้ว!');
    }

    // ลบข้อมูล
    public function destroy(WeightLog $weightLog)
    {
        $weightLog->delete();

        return redirect()->route('weights.index')->with('success', 'ลบข้อมูลเรียบร้อยแล้ว!');
    }
}