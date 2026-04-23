Name:           app-cpu-monitor
Version:        0.0.2
Release:        1%{?dist}
Summary:        CPU monitor app for ClearOS

License:        GPL-3.0-only
URL:            https://github.com/snuglinux/cpu-monitor
Source0:        cpu-monitor-%{version}.tar.gz

BuildArch:      noarch

Requires:       app-base
Requires:       app-dashboard

%global app_name cpu_monitor
%global app_root /usr/clearos/apps/%{app_name}

%description
CPU Monitor is a lightweight ClearOS application for real-time processor monitoring.

It displays total CPU usage, per-core load, CPU model information, and core count
directly in the ClearOS Webconfig interface. The plugin also includes a dashboard
widget for quick access to current processor activity.

%prep
%setup -q -n cpu-monitor-%{version}

%build
# Nothing to build

%install
rm -rf %{buildroot}

install -d %{buildroot}%{app_root}

cp -a controllers %{buildroot}%{app_root}/
cp -a deploy %{buildroot}%{app_root}/
cp -a language %{buildroot}%{app_root}/
cp -a views %{buildroot}%{app_root}/
cp -a htdocs %{buildroot}%{app_root}/

install -d %{buildroot}/usr/share/licenses/%{name}
install -m 0644 LICENSE %{buildroot}/usr/share/licenses/%{name}/LICENSE

install -d %{buildroot}/usr/share/doc/%{name}
install -m 0644 README.md %{buildroot}/usr/share/doc/%{name}/README.md

%files
%license /usr/share/licenses/%{name}/LICENSE
%doc /usr/share/doc/%{name}/README.md
%dir %{app_root}
%{app_root}/controllers
%{app_root}/deploy
%{app_root}/language
%{app_root}/views
%dir %{app_root}/htdocs

%changelog

* Thu Apr 16 2026 SnugLinux <snuglinux@ukr.net> - 0.0.1-1
- Initial RPM package for ClearOS CPU Monitor

* Thu Apr 23 2026 SnugLinux <snuglinux@ukr.net> - 0.0.2-1
- Fixed bugs with appearance

