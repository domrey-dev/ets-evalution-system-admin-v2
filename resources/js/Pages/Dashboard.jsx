import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { TASK_STATUS_CLASS_MAP, TASK_STATUS_TEXT_MAP } from "@/constants";
import { Head, Link, router } from "@inertiajs/react";
import SelectInput from "@/Components/SelectInput";
import PrimaryButton from "@/Components/PrimaryButton";

import { PieChart, Pie, Cell, LineChart, Line, XAxis, YAxis, CartesianGrid, Tooltip, Legend, ResponsiveContainer, Bar,BarChart } from 'recharts';
import React, { useState } from 'react';

export default function Dashboard({
  auth,
  totalPendingTasks,
  myPendingTasks,
  totalProgressTasks,
  myProgressTasks,
  totalCompletedTasks,
  myCompletedTasks,
  activeTasks,
  position = [],
  projects = [],
  departments = [],
  gradeDistribution,
  monthlyPerformance,
  projectPerformance,
  departmentPerformance,
  monthOptions = [],
  formattedGradeData
}) {

  const [selectedFilters, setSelectedFilters] = useState({
    month: '',
    project: '',
    department: '',
    customStartDate: '',
    customEndDate: ''
  });

  const handleFilterChange = (filterType, value) => {
    setSelectedFilters(prev => ({
      ...prev,
      [filterType]: value
    }));
  };

  const clearFilters = () => {
    setSelectedFilters({
      month: '',
      project: '',
      department: '',
      customStartDate: '',
      customEndDate: ''
    });
  };

  const applyFilters = () => {
    // Prepare filter data
    const filterData = {
      project: selectedFilters.project,
      department: selectedFilters.department,
    };
    
    // Handle custom date range
    if (selectedFilters.month === 'custom') {
      if (selectedFilters.customStartDate && selectedFilters.customEndDate) {
        filterData.start_date = selectedFilters.customStartDate;
        filterData.end_date = selectedFilters.customEndDate;
      }
    } else {
      filterData.month = selectedFilters.month;
    }

    // Remove empty filters
    Object.keys(filterData).forEach(key => {
      if (!filterData[key]) {
        delete filterData[key];
      }
    });

    // Send request to backend with the filters
    router.visit(route('dashboard'), {
      data: filterData,
      preserveState: true,
      replace: true,
      only: ['totalPendingTasks', 'myPendingTasks', 'totalProgressTasks', 'myProgressTasks', 
              'totalCompletedTasks', 'myCompletedTasks', 'monthlyPerformance', 'projectPerformance', 
              'departmentPerformance', 'formattedGradeData']
    });

    console.log('Applying filters:', filterData);
  };

  // Helper to format custom range label
  const getCustomRangeLabel = () => 'Custom';

  return (
    <AuthenticatedLayout
      auth={auth}
      header={
        <div className="flex justify-between items-center">
          <h2 className="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard
          </h2>
        </div>
      }
    >
      <Head title="Dashboard"/>
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
        <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div className="relative">
            <div className="p-4 sm:p-6">
              <div className="bg-gray-50 rounded-lg p-4 sm:p-6">
                                <div className="space-y-4">
                  <div className="flex flex-col lg:flex-row lg:items-end gap-4">
                    <div className="flex-1">
                      <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-4">
                        <div className="min-w-0">
                          <label className="block text-sm font-medium text-gray-700 mb-2">
                            Time Period
                          </label>
                          <SelectInput
                            className="w-full h-10 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                            value={selectedFilters.month}
                            onChange={(e) => handleFilterChange("month", e.target.value)}
                          >
                            {monthOptions.map((option) => (
                              <option key={option.value} value={option.value}>
                                {option.label}
                              </option>
                            ))}
                            <option value="custom">{getCustomRangeLabel()}</option>
                          </SelectInput>
                        </div>
                        <div className="min-w-0">
                          <label className="block text-sm font-medium text-gray-700 mb-2">
                            Project
                          </label>
                          <SelectInput
                            className="w-full h-10 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                            value={selectedFilters.project}
                            onChange={(e) => handleFilterChange("project", e.target.value)}
                          >
                            <option value="">All Projects</option>
                            {projects.map((project) => (
                              <option key={project.id} value={project.id}>
                                {project.name}
                              </option>
                            ))}
                          </SelectInput>
                        </div>
                        <div className="min-w-0 sm:col-span-2 lg:col-span-1">
                          <label className="block text-sm font-medium text-gray-700 mb-2">
                            Department
                          </label>
                          <SelectInput
                            className="w-full h-10 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                            value={selectedFilters.department}
                            onChange={(e) => handleFilterChange("department", e.target.value)}
                          >
                            <option value="">All Departments</option>
                            {departments.map((dept) => (
                              <option key={dept.value} value={dept.value}>
                                {dept.label}
                              </option>
                          ))}
                          </SelectInput>
                        </div>
                      </div>
                      
                      {/* Enhanced custom date range section */}
                      {selectedFilters.month === 'custom' && (
                        <div className="grid grid-cols-1 sm:grid-cols-2 gap-4 p-4 bg-gradient-to-r from-gray-50 to-blue-50 rounded-lg border border-gray-200 shadow-inner">
                          <div className="space-y-2">
                            <label className="block text-sm font-medium text-gray-700">
                              From Date
                            </label>
                            <input
                              type="date"
                              className="w-full h-10 border-gray-300 rounded-lg shadow-sm px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:ring-opacity-50 transition-all duration-200"
                              value={selectedFilters.customStartDate}
                              onChange={e => handleFilterChange('customStartDate', e.target.value)}
                            />
                          </div>
                          
                          <div className="space-y-2">
                            <label className="block text-sm font-medium text-gray-700">
                              To Date
                            </label>
                            <input
                              type="date"
                              className="w-full h-10 border-gray-300 rounded-lg shadow-sm px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:ring-opacity-50 transition-all duration-200"
                              value={selectedFilters.customEndDate}
                              onChange={e => handleFilterChange('customEndDate', e.target.value)}
                            />
                          </div>
                        </div>
                      )}
                    </div>
                    
                    <div className={`hidden lg:block w-px bg-gray-300 mx-4 ${selectedFilters.month === 'custom' ? 'h-32' : 'h-16'}`}></div>
                    
                    <div className="flex flex-row gap-3 lg:flex-shrink-0 lg:self-center">
                      <PrimaryButton
                        className="px-4 lg:px-6 py-2.5 bg-gray-600 hover:bg-gray-700 focus:ring-gray-500 text-white font-medium rounded-md shadow-sm transition-colors duration-200"
                        onClick={clearFilters}
                      >
                        Clear
                      </PrimaryButton>
                      <PrimaryButton
                        className="px-4 lg:px-6 py-2.5 bg-blue-600 hover:bg-blue-700 focus:ring-blue-500 text-white font-medium rounded-md shadow-sm transition-colors duration-200"
                        onClick={applyFilters}
                      >
                        Apply
                      </PrimaryButton>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div className="py-8 sm:py-12">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-5 gap-2 sm:gap-4 lg:gap-2">
          <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div className="p-2 sm:p-4 lg:p-6 text-gray-900">
              <h3 className="text-amber-500 text-xs sm:text-lg lg:text-2xl font-semibold">
                Total
              </h3>
              <p className="text-xs sm:text-lg lg:text-xl mt-1 sm:mt-2 lg:mt-4">
                <span className="mr-1 sm:mr-2">{myPendingTasks}</span>
              </p>
            </div>
          </div>
          <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div className="p-2 sm:p-4 lg:p-6 text-gray-900">
              <h3 className="text-amber-500 text-xs sm:text-lg lg:text-2xl font-semibold">
                Completed
              </h3>
              <p className="text-xs sm:text-lg lg:text-xl mt-1 sm:mt-2 lg:mt-4">
                <span className="mr-1 sm:mr-2">{myPendingTasks}</span>/
                <span className="ml-1 sm:ml-2">{totalPendingTasks}</span>
              </p>
            </div>
          </div>
          <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div className="p-2 sm:p-4 lg:p-6 text-gray-900">
              <h3 className="text-amber-500 text-xs sm:text-lg lg:text-2xl font-semibold">
                Incompleted
              </h3>
              <p className="text-xs sm:text-lg lg:text-xl mt-1 sm:mt-2 lg:mt-4">
                <span className="mr-1 sm:mr-2">{myPendingTasks}</span>/
                <span className="ml-1 sm:ml-2">{totalPendingTasks}</span>
              </p>
            </div>
          </div>
          <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div className="p-2 sm:p-4 lg:p-6 text-gray-900">
              <h3 className="text-blue-500 text-xs sm:text-lg lg:text-2xl font-semibold">
                New Staff
              </h3>
              <p className="text-xs sm:text-lg lg:text-xl mt-1 sm:mt-2 lg:mt-4">
                <span className="mr-1 sm:mr-2">{myProgressTasks}</span>/
                <span className="ml-1 sm:ml-2">{totalProgressTasks}</span>
              </p>
            </div>
          </div>
          <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div className="p-2 sm:p-4 lg:p-6 text-gray-900">
              <h3 className="text-green-500 text-xs sm:text-lg lg:text-2xl font-semibold">
                Resing Staff
              </h3>
              <p className="text-xs sm:text-lg lg:text-xl mt-1 sm:mt-2 lg:mt-4">
                <span className="mr-1 sm:mr-2">{myCompletedTasks}</span>/
                <span className="ml-1 sm:ml-2">{totalCompletedTasks}</span>
              </p>
            </div>
          </div>
        </div>


        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
          <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div className="relative">
              <div className="p-4">
                <div className="flex flex-col lg:flex-row w-full gap-4 p-2 sm:p-4">
                  <div className="bg-white rounded-lg shadow-md p-4 sm:p-6 w-full lg:w-1/2">
                    <h2 className="text-lg sm:text-xl font-bold mb-4 sm:mb-6">Grade Distribution</h2>
                    <div className="h-48 sm:h-64">
                      <ResponsiveContainer width="100%" height="100%">
                        <PieChart>
                          <Pie
                            data={formattedGradeData}
                            cx="50%"
                            cy="50%"
                            labelLine={false}
                            label={({name, percent}) => `${name} ${(percent * 100).toFixed(0)}%`}
                            outerRadius={80}
                            fill="#8884d8"
                            dataKey="value"
                          >
                            {formattedGradeData.map((entry, index) => (
                              <Cell key={`cell-${index}`} fill={entry.color}/>
                            ))}
                          </Pie>
                          <Tooltip/>
                          <Legend
                            layout="horizontal"
                            verticalAlign="bottom"
                            align="center"
                            iconType="circle"
                          />
                        </PieChart>
                      </ResponsiveContainer>
                    </div>
                  </div>

                  {/* Monthly Performance Trends chart */}
                  <div className="bg-white rounded-lg shadow-md p-4 sm:p-6 w-full lg:w-1/2">
                    <h2 className="text-lg sm:text-xl font-bold mb-4 sm:mb-6">Monthly Performance Trends</h2>
                    <div className="h-48 sm:h-64">
                      <ResponsiveContainer width="100%" height="100%">
                        <LineChart
                          data={Object.entries(monthlyPerformance).map(([month, value]) => ({
                            month,
                            value
                          }))}
                          margin={{top: 5, right: 30, left: 20, bottom: 5}}
                        >
                          <CartesianGrid strokeDasharray="3 3"/>
                          <XAxis dataKey="month"/>
                          <YAxis/>
                          <Tooltip/>
                          <Legend/>
                          <Line
                            type="monotone"
                            dataKey="value"
                            stroke="#0088FE"
                            activeDot={{r: 8}}
                            name="Performance"
                          />
                        </LineChart>
                      </ResponsiveContainer>
                    </div>
                    <p className="text-center text-gray-500 mt-4">Average Percentage</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
          <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div className="relative">
              <div className="p-4">
                <div className="flex flex-col lg:flex-row w-full gap-4 p-2 sm:p-4">
                  <div className="bg-white rounded-lg shadow-md p-4 sm:p-6 w-full lg:w-1/2">
                    <h2 className="text-lg sm:text-xl font-bold mb-4 sm:mb-6">Project Performance</h2>
                    <div className="h-48 sm:h-64">
                      <ResponsiveContainer width="100%" height="100%">
                        <BarChart
                          data={Object.entries(projectPerformance).map(([month, value]) => ({
                            name: month.substring(0, 3),
                            value,
                          }))}
                          margin={{top: 5, right: 30, left: 20, bottom: 5}}
                        >
                          <CartesianGrid strokeDasharray="3 3"/>
                          <XAxis dataKey="name"/>
                          <YAxis domain={[0, 1000]} ticks={[0, 200, 400, 600, 800, 1000]}/>
                          <Legend verticalAlign="bottom"/>
                          <Bar dataKey="value" fill="#6B7280" name="Value"/>
                        </BarChart>
                      </ResponsiveContainer>
                    </div>
                  </div>

                  <div className="bg-white rounded-lg shadow-md p-4 sm:p-6 w-full lg:w-1/2">
                    <h2 className="text-lg sm:text-xl font-bold mb-4 sm:mb-6">Department Performance</h2>
                    <div className="h-48 sm:h-64">
                      <ResponsiveContainer width="100%" height="100%">
                        <BarChart
                          data={Object.entries(departmentPerformance).map(([month, value]) => ({
                            name: month.substring(0, 3),
                            value,
                          }))}
                          margin={{top: 5, right: 30, left: 20, bottom: 5}}
                        >
                          <CartesianGrid strokeDasharray="3 3"/>
                          <XAxis dataKey="name"/>
                          <YAxis domain={[0, 1000]} ticks={[0, 200, 400, 600, 800, 1000]}/>
                          <Legend verticalAlign="bottom"/>
                          <Bar dataKey="value" fill="#6B7280" name="Value"/>
                        </BarChart>
                      </ResponsiveContainer>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>


      </div>
    </AuthenticatedLayout>
  )
}
