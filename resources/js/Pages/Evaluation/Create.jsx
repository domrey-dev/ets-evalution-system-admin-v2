import InputError from "@/Components/InputError";
import InputLabel from "@/Components/InputLabel";
import TextInput from "@/Components/TextInput";
import TextAreaInput from "@/Components/TextAreaInput";
import { Card, CardContent } from "@/Components/Card";
import PrimaryButton from "@/Components/PrimaryButton";
import SecondaryButton from "@/Components/SecondaryButton";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, Link, useForm } from "@inertiajs/react";
import { 
  ClipboardDocumentListIcon,
  DocumentTextIcon,
  ArrowLeftIcon
} from "@heroicons/react/24/outline";

export default function Create({ auth }) {
  const { data, setData, post, errors, processing } = useForm({
    title: "",
  });

  const onSubmit = (e) => {
    e.preventDefault();
    post(route("evaluations.store"));
  };

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
            <div>
              <h2 className="text-2xl font-bold text-gray-900">Create New Evaluation</h2>
              <p className="text-sm text-gray-600 mt-1">
                Create a new evaluation form for staff assessment
              </p>
            </div>
          </div>
          <div className="flex items-center space-x-2">
            <div className="flex items-center space-x-2 text-sm text-gray-500">
              <ClipboardDocumentListIcon className="w-4 h-4" />
              <span>New Evaluation</span>
            </div>
          </div>
        </div>
      }
    >
      <Head title="Create Evaluation" />

      <div className="py-8">
        <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
          <form onSubmit={onSubmit} className="space-y-6">
            {/* Evaluation Information Section */}
            <Card>
              <CardContent className="p-6">
                <div className="border-b border-gray-200 pb-4 mb-6">
                  <div className="flex items-center space-x-3">
                    <div className="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                      <DocumentTextIcon className="w-5 h-5 text-blue-600" />
                    </div>
                    <div>
                      <h3 className="text-lg font-semibold text-gray-900">Evaluation Information</h3>
                      <p className="text-sm text-gray-600">Basic information about the evaluation form</p>
                    </div>
                  </div>
                </div>

                {/* Khmer Header */}
                <div className="mb-6 p-4 bg-blue-50 rounded-lg border border-blue-200">
                  <h4 className="text-lg font-medium text-blue-900 mb-2">
                    ផ្នែកទី២: ចំណុចវាយតម្លៃ ការអនុវត្តការងារជាក់ស្តែងយោបល់បន្ថែម និងការឆ្លើយតបរបស់ប្រធានសាមី
                  </h4>
                  <p className="text-sm text-blue-700">
                    Section 2: Assessment Points, Practical Work Implementation, Additional Comments and Department Head Responses
                  </p>
                </div>

                <div className="grid grid-cols-1 gap-6">
                  {/* Evaluation Title */}
                  <div>
                    <InputLabel 
                      htmlFor="evaluation_title" 
                      value="Evaluation Title / កម្រងសំណួរទី" 
                      className="text-sm font-medium text-gray-700 mb-2" 
                    />
                    <div className="relative">
                      <TextInput
                        id="evaluation_title"
                        type="text"
                        name="title"
                        value={data.title}
                        className="mt-1 block w-full text-sm border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        placeholder="Enter evaluation title (e.g., Monthly Performance Review, Annual Assessment)"
                        onChange={(e) => setData("title", e.target.value)}
                        required
                      />
                    </div>
                    <InputError message={errors.title} className="mt-2" />
                    <p className="mt-2 text-xs text-gray-500">
                      Choose a descriptive title that clearly identifies the purpose and scope of this evaluation.
                    </p>
                  </div>
                </div>
              </CardContent>
            </Card>

            {/* Form Actions */}
            <div className="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0 pt-6 border-t border-gray-200">
              <div className="text-sm text-gray-500">
                <span className="font-medium">Note:</span> You can edit this evaluation after creating it.
              </div>
              
              <div className="flex items-center space-x-3">
                <SecondaryButton>
                  <Link href={route("evaluations.index")}>
                    Cancel
                  </Link>
                </SecondaryButton>
                
                <PrimaryButton 
                  type="submit" 
                  disabled={processing}
                  className="bg-blue-600 hover:bg-blue-700 focus:ring-blue-500"
                >
                  {processing ? (
                    <div className="flex items-center space-x-2">
                      <div className="w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></div>
                      <span>Creating...</span>
                    </div>
                  ) : (
                    <div className="flex items-center space-x-2">
                      <ClipboardDocumentListIcon className="w-4 h-4" />
                      <span>Create Evaluation</span>
                    </div>
                  )}
                </PrimaryButton>
              </div>
            </div>
          </form>
        </div>
      </div>
    </AuthenticatedLayout>
  );
}
