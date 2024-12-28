import { Link, Head } from "@inertiajs/react";
import { PageProps } from "@/types";
import Guest from "@/Layouts/GuestLayout";

export default function Welcome({
    auth,
    laravelVersion,
    phpVersion,
}: PageProps<{ laravelVersion: string; phpVersion: string }>) {
    const handleImageError = () => {
        document
            .getElementById("screenshot-container")
            ?.classList.add("!hidden");
        document.getElementById("docs-card")?.classList.add("!row-span-1");
        document
            .getElementById("docs-card-content")
            ?.classList.add("!flex-row");
        document.getElementById("background")?.classList.add("!hidden");
    };

    return (
        <Guest>
            <Head title="Welcome" />

            <div className="flex flex-col items-center gap-5 mt-4">
                <Link
                    href={route("register")}
                    className="px-4 w-full py-2 text-sm font-medium text-white bg-gray-600 hover:bg-gray-700 rounded-md"
                >
                    Register
                </Link>
                <Link
                    href={route("login")}
                    className="px-4 w-full py-2 text-sm font-medium text-white bg-gray-600 hover:bg-gray-700 rounded-md"
                >
                    Log In{" "}
                </Link>
            </div>
        </Guest>
    );
}
