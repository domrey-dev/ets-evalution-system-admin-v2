import Pagination from "@/Components/Pagination";
import SelectInput from "@/Components/SelectInput";
import TextInput from "@/Components/TextInput";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Card, CardContent } from "@/Components/Card";
import PrimaryButton from "@/Components/PrimaryButton";
import {
  PROJECT_STATUS_CLASS_MAP,
  PROJECT_STATUS_TEXT_MAP,
} from "@/constants.jsx";
import { Head, Link, router } from "@inertiajs/react";
import { useState } from "react";
import { 
  MagnifyingGlassIcon,
  PlusIcon,
  EyeIcon,
  PencilIcon,
  TrashIcon
} from "@heroicons/react/24/outline";
import { ChevronUpIcon, ChevronDownIcon } from "@heroicons/react/16/solid";
import { TASK_STATUS_CLASS_MAP, TASK_STATUS_TEXT_MAP } from "@/constants";

<style>
{`
.custom-select {
  appearance: none;
  -webkit-appearance: none;
  -moz-appearance: none;
  background-image: url("data:image/svg+xml;utf8,<svg fill='black' height='16' viewBox='0 0 24 24' width='16' xmlns='http://www.w3.org/2000/svg'><path d='M7 10l5 5 5-5z'/></svg>");
  background-repeat: no-repeat;
  background-position-x: 95%;
  background-position-y: 50%;
  padding-right: 2rem;
}
`}
</style>

export default function Index({ auth, projects, queryParams = null, success }) {
  queryParams = queryParams || {};
  
  const [filters, setFilters] = useState({
    name: queryParams.name || "",
    status: queryParams.status || ""
  });

  const handleFilterChange = (name, value) => {
    setFilters(prev => ({
      ...prev,
      [name]: value
    }));
  };

  const clearFilters = () => {
    const clearedFilters = {
      name: '',
      status: ''
    };
    setFilters(clearedFilters);
    
    // Automatically apply cleared filters
    router.get(route("project.index"), {}, {
      preserveState: true,
      replace: true,
    });
  };

  const applyFilters = () => {
    // Remove empty filters
    const filterData = {};
    Object.keys(filters).forEach(key => {
      if (filters[key]) {
        filterData[key] = filters[key];
      }
    });

    router.get(route("project.index"), filterData, {
      preserveState: true,
      replace: true,
    });
  };

  const handleKeyPress = (e) => {
    if (e.key === 'Enter') {
      applyFilters();
    }
  };

  const deleteProject = (project) => {
    if (!window.confirm("Are you sure you want to delete the project?")) {
      return;
    }
    router.delete(route("project.destroy", project.id));
  };

  return (
    <AuthenticatedLayout
        auth={auth}
      header={
        <div className="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
          <div>
            <h2 className="text-2xl font-bold text-gray-900">Projects</h2>
            <p className="text-sm text-gray-600 mt-1">
              Manage and track your projects
            </p>
          </div>
          <Link
            href={route("project.create")}
            className="inline-flex items-center px-4 py-2 bg-emerald-600 text-white text-sm font-medium rounded-lg hover:bg-emerald-700 shadow-sm transition-all duration-200"
          >
            <PlusIcon className="w-4 h-4 mr-2" />
            New Project
          </Link>
        </div>
      }
    >
      <Head title="Projects" />

      <div className="py-8">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          {/* Success Message */}
          {success && (
            <div className="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-lg">
              {success}
            </div>
          )}

          {/* Filters and Search */}
          <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div className="p-6 text-gray-900">
              <div className="bg-gray-50 rounded-lg p-4 sm:p-6 mb-6">
                {/* <h3 className="text-lg font-semibold text-gray-900 mb-4">Filter Projects</h3> */}
                <div className="flex flex-col lg:flex-row lg:items-end gap-4">
                  <div className="flex-1">
                    <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                      <div className="min-w-0">
                        <label className="block text-sm font-medium text-gray-700 mb-2">
                          Project Name
                        </label>
                        <TextInput
                          className="w-full h-10 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                          defaultValue={queryParams?.name}
                          placeholder="Search by name..."
                          value={filters.name}
                          onChange={(e) => setFilters({...filters, name: e.target.value})}
                          onKeyPress={handleKeyPress}
                        />
                      </div>
                      <div className="min-w-0">
                        <label className="block text-sm font-medium text-gray-700 mb-2">
                          Status
                        </label>
                        <SelectInput
                          className="w-full h-10 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                          value={filters.status}
                          onChange={(e) => setFilters({...filters, status: e.target.value})}
                          onKeyPress={handleKeyPress}
                        >
                          <option value="">All Status</option>
                          <option value="pending">Pending</option>
                          <option value="in_progress">In Progress</option>
                          <option value="completed">Completed</option>
                        </SelectInput>
                      </div>
                    </div>
                  </div>
                  
                  <div className="hidden lg:block w-px h-16 bg-gray-300 mx-4"></div>
                  
                  <div className="flex flex-row gap-3 lg:flex-shrink-0">
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

          {/* Table */}
          <Card>
            <div className="overflow-x-auto">
              <table className="min-w-full divide-y divide-gray-200">
                <thead className="bg-gray-50">
                  <tr>
                    <th className="px-2 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-12 sm:w-16">
                      ID
                    </th>
                    <th className="px-2 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                      Project Name
                    </th>
                    <th className="px-2 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                      Description
                    </th>
                    <th className="px-2 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-24 sm:w-32">
                      Status
                    </th>
                    <th className="px-2 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-24 sm:w-32">
                      Due Date
                    </th>
                    <th className="px-2 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-24 sm:w-32">
                      Created By
                    </th>
                    <th className="px-2 sm:px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider w-20 sm:w-32">
                      Actions
                    </th>
                  </tr>
                </thead>
                <tbody className="bg-white divide-y divide-gray-200">
                  {projects.data.map((project) => (
                    <tr key={project.id} className="hover:bg-gray-50">
                      <td className="px-2 sm:px-4 py-3 sm:py-4 whitespace-nowrap text-xs sm:text-sm font-medium text-gray-900">
                        {project.id}
                      </td>
                      <td className="px-2 sm:px-4 py-3 sm:py-4">
                        <div className="text-xs sm:text-sm font-medium text-gray-900 truncate">
                          {project.name}
                        </div>
                      </td>
                      <td className="px-2 sm:px-4 py-3 sm:py-4">
                        <div className="text-xs sm:text-sm text-gray-900 max-w-xs truncate">
                          {project.description || "No description"}
                        </div>
                      </td>
                      <td className="px-2 sm:px-4 py-3 sm:py-4 whitespace-nowrap">
                        <span
                          className={`inline-flex px-1 sm:px-2 py-1 text-xs font-semibold rounded-full text-white ${
                            PROJECT_STATUS_CLASS_MAP[project.status]
                          }`}
                        >
                          <span className="hidden sm:inline">{PROJECT_STATUS_TEXT_MAP[project.status]}</span>
                          <span className="sm:hidden">
                            {PROJECT_STATUS_TEXT_MAP[project.status]?.substring(0, 3)}
                          </span>
                        </span>
                      </td>
                      <td className="px-2 sm:px-4 py-3 sm:py-4 whitespace-nowrap text-xs sm:text-sm text-gray-900">
                        {project.due_date}
                      </td>
                      <td className="px-2 sm:px-4 py-3 sm:py-4 whitespace-nowrap text-xs sm:text-sm text-gray-900">
                        {project.createdBy?.name}
                      </td>
                      <td className="px-2 sm:px-4 py-3 sm:py-4 whitespace-nowrap text-right text-xs sm:text-sm font-medium">
                        <div className="flex items-center justify-end space-x-1 sm:space-x-2">
                          <Link
                            href={route("project.show", project.id)}
                            className="text-blue-600 hover:text-blue-900 transition-colors"
                            title="View"
                          >
                            <EyeIcon className="w-3 h-3 sm:w-4 sm:h-4" />
                          </Link>
                          <Link
                            href={route("project.edit", project.id)}
                            className="text-emerald-600 hover:text-emerald-900 transition-colors"
                            title="Edit"
                          >
                            <PencilIcon className="w-3 h-3 sm:w-4 sm:h-4" />
                          </Link>
                          <button
                            onClick={() => deleteProject(project)}
                            className="text-red-600 hover:text-red-900 transition-colors"
                            title="Delete"
                          >
                            <TrashIcon className="w-3 h-3 sm:w-4 sm:h-4" />
                          </button>
                        </div>
                      </td>
                    </tr>
                  ))}
                </tbody>
              </table>
            </div>
          </Card>

          {/* Empty State */}
          {projects.data.length === 0 && (
            <Card className="text-center py-12 mt-6">
              <CardContent>
                <div className="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                  <PlusIcon className="w-12 h-12 text-gray-400" />
                </div>
                <h3 className="text-lg font-medium text-gray-900 mb-2">No projects found</h3>
                <p className="text-gray-500 mb-6">
                  Get started by creating your first project.
                </p>
                <Link
                  href={route("project.create")}
                  className="inline-flex items-center px-4 py-2 bg-emerald-600 text-white text-sm font-medium rounded-lg hover:bg-emerald-700 transition-all"
                >
                  <PlusIcon className="w-4 h-4 mr-2" />
                  Create Project
                </Link>
              </CardContent>
            </Card>
          )}

          {/* Pagination */}
          {projects.data.length > 0 && (
            <div className="mt-6">
              <Pagination links={projects.meta.links} />
            </div>
          )}
        </div>
      </div>
    </AuthenticatedLayout>
  );
}
