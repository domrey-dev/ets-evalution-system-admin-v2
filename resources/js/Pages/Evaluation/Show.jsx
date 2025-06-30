import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, Link } from "@inertiajs/react";
import { Card, CardContent } from "@/Components/Card";
import {
  ClipboardDocumentListIcon,
  UserIcon,
  CalendarIcon,
  PencilIcon,
  ArrowLeftIcon,
  ChartBarIcon,
  ClockIcon,
  DocumentTextIcon
} from "@heroicons/react/24/outline";

export default function Show({ auth, evaluation: evaluationData, statistics }) {
  const evaluation = evaluationData.data
  return (
    <AuthenticatedLayout
        auth={auth}
      header={
        <div className="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
          <div className="flex items-center space-x-4">
            <Link
              href={route("evaluations.index")}
              className="inline-flex items-center p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition-all"
            >
              <ArrowLeftIcon className="w-5 h-5" />
            </Link>
            <div className="flex items-center space-x-3">
              <div className="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                <ClipboardDocumentListIcon className="w-6 h-6 text-blue-600" />
              </div>
              <div>
                <h2 className="text-2xl font-bold text-gray-900 line-clamp-1">
                  {evaluation.title}
                </h2>
                <p className="text-sm text-gray-600">Evaluation #{evaluation.id}</p>
              </div>
            </div>
          </div>
          <Link
            href={route("evaluations.edit", evaluation.id)}
            className="inline-flex items-center px-4 py-2 bg-emerald-600 text-white text-sm font-medium rounded-lg hover:bg-emerald-700 shadow-sm transition-all"
          >
            <PencilIcon className="w-4 h-4 mr-2" />
            Edit Evaluation
          </Link>
        </div>
      }
    >
      <Head title={`Evaluation: ${evaluation.title}`} />

      <div className="py-8">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {/* Main Content */}
            <div className="lg:col-span-2 space-y-6">
              {/* Evaluation Header */}
              <Card>
                <CardContent className="p-6">
                  <div className="space-y-6">
                    {/* Khmer Section Header */}
                    <div className="p-4 bg-blue-50 rounded-lg border border-blue-200">
                      <h3 className="text-lg font-medium text-blue-900 mb-2">
                        ផ្នែកទី២: ចំណុចវាយតម្លៃ ការអនុវត្តការងារជាក់ស្តែងយោបល់បន្ថែម និងការឆ្លើយតបរបស់ប្រធានសាមី
                      </h3>
                      <p className="text-sm text-blue-700">
                        Section 2: Assessment Points, Practical Work Implementation, Additional Comments and Department Head Responses
                      </p>
                    </div>

                    {/* Evaluation Title */}
                    <div>
                      <h4 className="text-xl font-semibold text-gray-900 mb-4">
                        {evaluation.title}
                      </h4>
                      <div className="prose max-w-none text-gray-700">
                        <p>
                          This evaluation form is designed to assess staff performance and gather feedback 
                          for continuous improvement. The form includes assessment criteria, practical work 
                          evaluation, and space for additional comments from both evaluators and department heads.
                        </p>
                      </div>
                    </div>

                    {/* Evaluation Stats */}
                    <div className="grid grid-cols-1 sm:grid-cols-3 gap-4">
                      <div className="bg-gray-50 rounded-lg p-4 text-center">
                        <div className="flex items-center justify-center mb-2">
                          <ChartBarIcon className="w-5 h-5 text-blue-600" />
                        </div>
                        <div className="text-2xl font-bold text-gray-900">{statistics.total_responses}</div>
                        <div className="text-sm text-gray-600">Total Responses</div>
                      </div>
                      <div className="bg-gray-50 rounded-lg p-4 text-center">
                        <div className="flex items-center justify-center mb-2">
                          <ClockIcon className="w-5 h-5 text-green-600" />
                        </div>
                        <div className="text-2xl font-bold text-gray-900">Active</div>
                        <div className="text-sm text-gray-600">Status</div>
                      </div>
                      <div className="bg-gray-50 rounded-lg p-4 text-center">
                        <div className="flex items-center justify-center mb-2">
                          <DocumentTextIcon className="w-5 h-5 text-purple-600" />
                        </div>
                        <div className="text-2xl font-bold text-gray-900">1</div>
                        <div className="text-sm text-gray-600">Questions</div>
                      </div>
                    </div>
                  </div>
                </CardContent>
              </Card>

              {/* Evaluation Details */}
              <Card>
                <CardContent className="p-6">
                  <div className="border-b border-gray-200 pb-4 mb-6">
                    <h3 className="text-lg font-semibold text-gray-900">Evaluation Details</h3>
                    <p className="text-sm text-gray-600">Additional information about this evaluation</p>
                  </div>

                  <div className="space-y-6">
                    <div className="grid grid-cols-1 sm:grid-cols-2 gap-6">
                      <div>
                        <label className="text-sm font-medium text-gray-700 block mb-2">
                          Evaluation ID
                        </label>
                        <p className="text-sm text-gray-900">#{evaluation.id}</p>
                      </div>
                      <div>
                        <label className="text-sm font-medium text-gray-700 block mb-2">
                          Status
                        </label>
                        <span className="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                          Active
                        </span>
                      </div>
                    </div>

                    <div>
                      <label className="text-sm font-medium text-gray-700 block mb-2">
                        Purpose & Scope
                      </label>
                      <div className="prose max-w-none text-gray-700">
                        <p className="text-sm">
                          This evaluation is designed to comprehensively assess employee performance, 
                          identify areas for improvement, and provide constructive feedback for professional 
                          development. It covers various aspects of job performance including work quality, 
                          productivity, collaboration, and adherence to organizational values.
                        </p>
                      </div>
                    </div>
                  </div>
                </CardContent>
              </Card>

              {/* Response Summary */}
              <Card>
                <CardContent className="p-6">
                  <div className="border-b border-gray-200 pb-4 mb-6">
                    <h3 className="text-lg font-semibold text-gray-900">Response Summary</h3>
                    <p className="text-sm text-gray-600">Overview of evaluation responses</p>
                  </div>

                  <div className="text-center py-8">
                    <div className="mx-auto w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                      <ChartBarIcon className="w-8 h-8 text-gray-400" />
                    </div>
                    <h4 className="text-lg font-medium text-gray-900 mb-2">No Responses Yet</h4>
                    <p className="text-gray-500 mb-4">
                      This evaluation hasn't received any responses yet. Once staff members complete the evaluation, 
                      you'll see summary statistics and insights here.
                    </p>
                  </div>
                </CardContent>
              </Card>
            </div>

            {/* Sidebar */}
            <div className="space-y-6">
              {/* Creator Information */}
              <Card>
                <CardContent className="p-6">
                  <h3 className="text-lg font-semibold text-gray-900 mb-4">Creator Information</h3>
                  <div className="space-y-4">
                    <div className="flex items-center space-x-3">
                      <div className="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center">
                        <UserIcon className="w-5 h-5 text-gray-600" />
                      </div>
                      <div>
                        <p className="text-sm font-medium text-gray-900">
                          {evaluation.createdBy?.name || 'Unknown User'}
                        </p>
                        <p className="text-xs text-gray-500">Created by</p>
                      </div>
                    </div>
                    <div className="flex items-center space-x-3">
                      <div className="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center">
                        <UserIcon className="w-5 h-5 text-gray-600" />
                      </div>
                      <div>
                        <p className="text-sm font-medium text-gray-900">
                          {evaluation.updatedBy?.name || 'Unknown User'}
                        </p>
                        <p className="text-xs text-gray-500">Last updated by</p>
                      </div>
                    </div>
                  </div>
                </CardContent>
              </Card>

              {/* Timeline */}
              <Card>
                <CardContent className="p-6">
                  <h3 className="text-lg font-semibold text-gray-900 mb-4">Timeline</h3>
                  <div className="space-y-4">
                    <div className="flex items-center space-x-3">
                      <div className="w-2 h-2 bg-blue-600 rounded-full"></div>
                      <div className="flex-1">
                        <p className="text-sm font-medium text-gray-900">Created</p>
                        <p className="text-xs text-gray-500 flex items-center">
                          <CalendarIcon className="w-3 h-3 mr-1" />
                          {evaluation.created_at}
                        </p>
                      </div>
                    </div>
                    <div className="flex items-center space-x-3">
                      <div className="w-2 h-2 bg-green-600 rounded-full"></div>
                      <div className="flex-1">
                        <p className="text-sm font-medium text-gray-900">Last Updated</p>
                        <p className="text-xs text-gray-500 flex items-center">
                          <CalendarIcon className="w-3 h-3 mr-1" />
                          {evaluation.updated_at}
                        </p>
                      </div>
                    </div>
                  </div>
                </CardContent>
              </Card>

              {/* Quick Actions */}
              <Card>
                <CardContent className="p-6">
                  <h3 className="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
                  <div className="space-y-3">
                    <Link
                      href={route("evaluations.edit", evaluation.id)}
                      className="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-all"
                    >
                      <PencilIcon className="w-4 h-4 mr-2" />
                      Edit Evaluation
                    </Link>
                    <button
                      className="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-all"
                      disabled
                    >
                      <ChartBarIcon className="w-4 h-4 mr-2" />
                      View Analytics
                    </button>
                  </div>
                </CardContent>
              </Card>
            </div>
          </div>
        </div>
      </div>
    </AuthenticatedLayout>
  );
}
