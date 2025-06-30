import React from "react";
import { Head, usePage } from "@inertiajs/react";
import { Card, CardContent } from "@/Components/Card";
import { Button } from "@/Components/Button";
import {
  PieChart,
  Pie,
  Tooltip,
  LineChart,
  Line,
  XAxis,
  YAxis,
  CartesianGrid,
} from "recharts";

export default function Dashboard() {
  const {
    total,
    complete,
    incomplete,
    newStaff,
    resignStaff,
    gradeDistribution,
    monthlyTrends,
  } = usePage().props;

  return (
    <div className="p-6 bg-gray-100 min-h-screen">
      <Head title="Staff Evaluation Dashboard" />
      <h1 className="text-3xl font-semibold mb-6">Dashboard</h1>

      <div className="grid grid-cols-5 gap-4 mb-6">
        {[
          { label: "Total", value: total, color: "text-blue-600" },
          { label: "Complete", value: complete, color: "text-green-600" },
          { label: "Incomplete", value: incomplete, color: "text-yellow-600" },
          { label: "New Staff", value: newStaff, color: "text-gray-600" },
          { label: "Resign Staff", value: resignStaff, color: "text-red-600" },
        ].map((stat, index) => (
          <Card key={index} className="shadow-lg p-4 rounded-xl bg-white">
            <CardContent>
              <h2 className="text-lg font-medium text-gray-700">
                {stat.label}
              </h2>
              <p className={`text-2xl font-bold ${stat.color}`}>{stat.value}</p>
            </CardContent>
          </Card>
        ))}
      </div>

      <div className="grid grid-cols-2 gap-6">
        <Card className="p-4 shadow-lg bg-white rounded-xl">
          <h2 className="text-lg font-semibold mb-3">Grade Distribution</h2>
          <PieChart width={300} height={300}>
            <Pie
              data={gradeDistribution}
              dataKey="value"
              nameKey="name"
              cx="50%"
              cy="50%"
              outerRadius={80}
              fill="#8884d8"
            />
            <Tooltip />
          </PieChart>
        </Card>

        <Card className="p-4 shadow-lg bg-white rounded-xl">
          <h2 className="text-lg font-semibold mb-3">
            Monthly Performance Trends
          </h2>
          <LineChart width={400} height={300} data={monthlyTrends}>
            <CartesianGrid strokeDasharray="3 3" />
            <XAxis dataKey="month" />
            <YAxis />
            <Tooltip />
            <Line
              type="monotone"
              dataKey="value"
              stroke="#8884d8"
              strokeWidth={2}
            />
          </LineChart>
        </Card>
      </div>

      <div className="flex gap-4 mt-6">
        <Button className="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
          Import
        </Button>
        <Button className="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">
          Export
        </Button>
      </div>
    </div>
  );
}
